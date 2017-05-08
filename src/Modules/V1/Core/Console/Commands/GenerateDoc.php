<?php

namespace App\Modules\V1\Core\Console\Commands;

use Illuminate\Console\Command;

class GenerateDoc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'doc:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate api documentation';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $docData = [];
        $routes  = $this->getRoutes();
        foreach ($routes as $route) 
        {
            if ($route) 
            {
                $actoinArray      = explode('@', $route['action']);
                $controller       = $actoinArray[0];
                $method           = $actoinArray[1];
                $route['name']    = $method !== 'index' ? $method : 'list';
                
                $reflectionClass  = new \ReflectionClass($controller);
                $reflectionMethod = $reflectionClass->getMethod($method);
                $classProperties  = $reflectionClass->getDefaultProperties();
                $skipLoginCheck   = array_key_exists('skipLoginCheck', $classProperties) ? $classProperties['skipLoginCheck'] : false;
                $validationRules  = array_key_exists('validationRules', $classProperties) ? $classProperties['validationRules'] : false;

                $this->processDocBlock($route, $reflectionMethod);
                $this->getHeaders($route, $reflectionClass, $method, $skipLoginCheck);
                $this->getPostData($route, $reflectionMethod, $validationRules);

                preg_match('/api\/v1\/([^#]+)\//iU', $route['uri'], $module);
                preg_match('/api\/v1\/' . $module[1] . '\/([^#]+)\//iU', $route['uri'], $model);
                $docData['modules'][$module[1]][$model[1]][] = $route;
            }
        }
        $docData['errors'] = $this->getErrors();
        \File::put(app_path('Modules/V1/Core/Resources/api.json'), json_encode($docData));
    }

    /**
     * Get list of all registered routes.
     * 
     * @return collection
     */
    protected function getRoutes()
    {
        return collect(\Route::getRoutes())->map(function ($route) {
            if (strpos($route->uri(), 'api/v') !== false) 
            {
                return [
                    'method' => $route->methods()[0],
                    'uri'    => $route->uri(),
                    'action' => $route->getActionName()
                ];
            }
            return false;
        })->all();
    }

    /**
     * Generate headers for the given route.
     * 
     * @param  array  &$route
     * @param  object $reflectionClass
     * @param  string $method
     * @param  array  $skipLoginCheck
     * @return void
     */
    protected function getHeaders(&$route, $reflectionClass, $method, $skipLoginCheck)
    {
        $route['headers'] = [
        'Accept'         => 'application/json',
        'Content-Type'   => 'application/json',
        'locale'         => 'The language of the returned data: ar, en or all.',
        'time-zone-diff' => 'Timezone difference between UTC and Local Time',
        ];


        if (! $skipLoginCheck || ! in_array($method, $skipLoginCheck)) 
        {
            $route['headers']['Authrization'] = 'bearer {token}';
        }
    }

    /**
     * Generate description and params for the given route
     * based on the docblock.
     * 
     * @param  array  &$route
     * @param  object $reflectionMethod]
     * @return void
     */
    protected function processDocBlock(&$route, $reflectionMethod)
    {
        $factory              = \phpDocumentor\Reflection\DocBlockFactory::createInstance();
        $docblock             = $factory->create($reflectionMethod->getDocComment());
        $route['description'] = trim(preg_replace('/\s+/', ' ', $docblock->getSummary()));
        $params               = $docblock->getTagsByName('param');
        foreach ($params as $param) 
        {
            $name = $param->getVariableName();
            if ($name !== 'request') 
            {
                $route['parametars'][$param->getVariableName()] = $param->getDescription()->render();
            }
        }
    }

    /**
     * Generate post body for the given route.
     * 
     * @param  array  &$route
     * @param  object $reflectionMethod
     * @param  array  $validationRules
     * @return void
     */
    protected function getPostData(&$route, $reflectionMethod, $validationRules)
    {
        if ($route['method'] == 'POST') 
        {
            $body = $this->getMethodBody($reflectionMethod);

            preg_match('/\$this->validate\(\$request,([^#]+)\);/iU', $body, $match);
            if (count($match)) 
            {
                if ($match[1] == '$this->validationRules')
                {
                    $route['body'] = $validationRules;
                }
                else
                {
                    $route['body'] = eval('return ' . $match[1] . ';');
                }

                foreach ($route['body'] as &$rule) 
                {
                    if(strpos($rule, 'unique'))
                    {
                        $rule = substr($rule, 0, strpos($rule, 'unique') + 6);
                    }
                    elseif(strpos($rule, 'exists'))
                    {
                        $rule = substr($rule, 0, strpos($rule, 'exists') - 1);
                    }
                }
            }
            else
            {
                $route['body'] = 'conditions';
            }
        }
    }

    /**
     * Generate application errors.
     * 
     * @return array
     */
    protected function getErrors()
    {
        $errors          = [];
        $reflectionClass = new \ReflectionClass('App\Modules\V1\Core\Utl\ErrorHandler');
        foreach ($reflectionClass->getMethods() as $method) 
        {
            $methodName       = $method->getName();
            $reflectionMethod = $reflectionClass->getMethod($methodName);
            $body             = $this->getMethodBody($reflectionMethod);

            preg_match('/\$error=\[\'status\'=>([^#]+)\,/iU', $body, $match);

            if (count($match)) 
            {
                $errors[$match[1]][] = $methodName;
            }
        }

        return $errors;
    }

    /**
     * Get the fiven method body code.
     * 
     * @param  object $reflectionMethod
     * @return string
     */
    protected function getMethodBody($reflectionMethod)
    {
        $filename   = $reflectionMethod->getFileName();
        $start_line = $reflectionMethod->getStartLine() - 1;
        $end_line   = $reflectionMethod->getEndLine();
        $length     = $end_line - $start_line;         
        $source     = file($filename);
        $body       = implode("", array_slice($source, $start_line, $length));
        $body       = trim(preg_replace('/\s+/', '', $body));

        return $body;
    }
}
