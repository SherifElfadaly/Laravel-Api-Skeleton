<?php

namespace App\Modules\Core\Console\Commands;

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
        $docData           = [];
        $docData['models'] = [];
        $routes            = $this->getRoutes();
        foreach ($routes as $route) 
        {
            if ($route) 
            {
                $actoinArray = explode('@', $route['action']);
                if(array_get($actoinArray, 1, false))
                {
                    $controller       = $actoinArray[0];
                    $method           = $actoinArray[1];
                    $route['name']    = $method !== 'index' ? $method : 'list';
                    
                    $reflectionClass  = new \ReflectionClass($controller);
                    $reflectionMethod = $reflectionClass->getMethod($method);
                    $classProperties  = $reflectionClass->getDefaultProperties();
                    $skipLoginCheck   = array_key_exists('skipLoginCheck', $classProperties) ? $classProperties['skipLoginCheck'] : false;
                    $validationRules  = array_key_exists('validationRules', $classProperties) ? $classProperties['validationRules'] : false;

                    $this->processDocBlock($route, $reflectionMethod);
                    $this->getHeaders($route, $method, $skipLoginCheck);
                    $this->getPostData($route, $reflectionMethod, $validationRules);

                    $route['response'] = $this->getResponseObject($classProperties['model'], $route['name'], $route['returnDocBlock']);

                    preg_match('/api\/([^#]+)\//iU', $route['uri'], $module);
                    $docData['modules'][$module[1]][substr($route['prefix'], strlen('/api/' . $module[1] . '/') - 1)][] = $route;

                    $this->getModels($classProperties['model'], $docData);   
                }
            }
        }
        
        $docData['errors']  = $this->getErrors();
        $docData['reports'] = \Core::reports()->all();
        \File::put(app_path('Modules/Core/Resources/api.json'), json_encode($docData));
    }

    /**
     * Get list of all registered routes.
     * 
     * @return collection
     */
    protected function getRoutes()
    {
        return collect(\Route::getRoutes())->map(function ($route) {
            if (strpos($route->uri(), 'api') !== false) 
            {
                return [
                    'method' => $route->methods()[0],
                    'uri'    => $route->uri(),
                    'action' => $route->getActionName(),
                    'prefix' => $route->getPrefix()
                ];
            }
            return false;
        })->all();
    }

    /**
     * Generate headers for the given route.
     * 
     * @param  array  &$route
     * @param  string $method
     * @param  array  $skipLoginCheck
     * @return void
     */
    protected function getHeaders(&$route, $method, $skipLoginCheck)
    {
        $route['headers'] = [
        'Accept'       => 'application/json',
        'Content-Type' => 'application/json',
        'locale'       => 'The language of the returned data: ar, en or all.',
        'time-zone'    => 'Your locale time zone',
        ];


        if (! $skipLoginCheck || ! in_array($method, $skipLoginCheck)) 
        {
            $route['headers']['Authorization'] = 'Bearer {token}';
        }
    }

    /**
     * Generate description and params for the given route
     * based on the docblock.
     * 
     * @param  array  &$route
     * @param  object $reflectionMethod
     * @return void
     */
    protected function processDocBlock(&$route, $reflectionMethod)
    {
        $factory                 = \phpDocumentor\Reflection\DocBlockFactory::createInstance();
        $docblock                = $factory->create($reflectionMethod->getDocComment());
        $route['description']    = trim(preg_replace('/\s+/', ' ', $docblock->getSummary()));
        $params                  = $docblock->getTagsByName('param');
        $route['returnDocBlock'] = $docblock->getTagsByName('return')[0]->getType()->getFqsen()->getName();
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
                    $route['body'] = eval('return ' . str_replace(',\'.$request->get(\'id\')', ',{id}\'', $match[1]) . ';');
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
        $reflectionClass = new \ReflectionClass('App\Modules\Core\Utl\ErrorHandler');
        foreach ($reflectionClass->getMethods() as $method) 
        {
            $methodName       = $method->name;
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
     * Get the given method body code.
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

    /**
     * Get example object of all availble models.
     * 
     * @param  string $modelName
     * @param  array  $docData
     * @return string
     */
    protected function getModels($modelName, &$docData)
    {
        if ($modelName && ! array_key_exists($modelName, $docData['models'])) 
        {
            $modelClass = call_user_func_array("\Core::{$modelName}", [])->modelClass;
            $model      = factory($modelClass)->make();
            $modelArr   = $model->toArray();

            if ( $model->trans && ! $model->trans->count()) 
            {
                $modelArr['trans'] = [
                    'en' => factory($modelClass . 'Translation')->make()->toArray()
                ];
            }

            $docData['models'][$modelName] = json_encode($modelArr, JSON_PRETTY_PRINT);
        }
    }

    /**
     * Get the route response object type.
     * 
     * @param  string $modelName
     * @param  string $method
     * @param  string $returnDocBlock
     * @return array
     */
    protected function getResponseObject($modelName, $method, $returnDocBlock)
    {
        $config    = \CoreConfig::getConfig();
        $relations = array_key_exists($modelName, $config['relations']) ? array_key_exists($method, $config['relations'][$modelName]) ? $config['relations'][$modelName] : false : false;
        $modelName = call_user_func_array("\Core::{$returnDocBlock}", []) ? $returnDocBlock : $modelName;

        return $relations ? [$modelName => $relations && $relations[$method] ? $relations[$method] : []] : false;
    }
}
