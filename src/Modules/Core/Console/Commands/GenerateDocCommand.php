<?php

namespace App\Modules\Core\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use App\Modules\Reporting\Services\ReportService;

class GenerateDocCommand extends Command
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
     * @var ReprotService
     */
    protected $reportService;

    /**
     * Init new object.
     *
     * @return  void
     */
    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
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
        foreach ($routes as $route) {
            if ($route) {
                $actoinArray = explode('@', $route['action']);
                if (Arr::get($actoinArray, 1, false)) {

                    $prefix = $route['prefix'];
                    $module = \Str::camel(str_replace('/', '_', str_replace('api', '', $prefix)));
                    if($prefix === 'telescope') {
                        continue;
                    }

                    $controller       = $actoinArray[0];
                    $method           = $actoinArray[1];
                    $route['name']    = $method !== 'index' ? $method : 'list';
                    
                    $reflectionClass  = new \ReflectionClass($controller);
                    $reflectionMethod = $reflectionClass->getMethod($method);
                    $classProperties  = $reflectionClass->getDefaultProperties();
                    $skipLoginCheck   = Arr::get($classProperties, 'skipLoginCheck', false);
                    $modelName        = explode('\\', $controller);
                    $modelName        = lcfirst(str_replace('Controller', '', end($modelName)));

                    $this->processDocBlock($route, $reflectionMethod);
                    $this->getHeaders($route, $method, $skipLoginCheck);
                    $this->getPostData($route, $reflectionMethod);

                    $route['response'] = $this->getResponseObject($modelName, $route['name'], $route['returnDocBlock']);
                    $docData['modules'][$module][] = $route;

                    $this->getModels($modelName, $docData, $reflectionClass);
                }
            }
        }
        
        $docData['errors']  = $this->getErrors();
        $docData['reports'] = $this->reportService->all();
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
            if (strpos($route->uri(), 'api/') !== false) {
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


        if (! $skipLoginCheck || ! in_array($method, $skipLoginCheck)) {
            $route['headers']['Authorization'] = 'Bearer {token}';
        }
    }

    /**
     * Generate description and params for the given route
     * based on the docblock.
     *
     * @param  array  &$route
     * @param  \ReflectionMethod $reflectionMethod
     * @return void
     */
    protected function processDocBlock(&$route, $reflectionMethod)
    {
        $factory                 = \phpDocumentor\Reflection\DocBlockFactory::createInstance();
        $docblock                = $factory->create($reflectionMethod->getDocComment());
        $route['description']    = trim(preg_replace('/\s+/', ' ', $docblock->getSummary()));
        $params                  = $docblock->getTagsByName('param');
        $route['returnDocBlock'] = $docblock->getTagsByName('return')[0]->getType()->getFqsen()->getName();

        foreach ($params as $param) {
            $name = $param->getVariableName();
            if ($name !== 'request') {
                $route['parametars'][$param->getVariableName()] = $param->getDescription()->render();
            }
        }

        if ($route['name'] === 'list') {
            $route['parametars']['perPage'] = 'perPage?';
            $route['parametars']['sortBy']  = 'sortBy?';
            $route['parametars']['desc']    = 'desc?';
            $route['parametars']['trashed'] = 'trashed?';
        }
    }

    /**
     * Generate post body for the given route.
     *
     * @param  array  &$route
     * @param  \ReflectionMethod $reflectionMethod
     * @return void
     */
    protected function getPostData(&$route, $reflectionMethod)
    {
        $parameters = $reflectionMethod->getParameters();
        if (count($parameters)) {
            $className = optional($reflectionMethod->getParameters()[0]->getType())->getName();
            if ($className) {
                $reflectionClass  = new \ReflectionClass($className);
    
                if ($reflectionClass->hasMethod('rules')) {
                    $reflectionMethod = $reflectionClass->getMethod('rules');
                    $route['body'] = $reflectionMethod->invoke(new $className);
        
                    foreach ($route['body'] as &$rule) {
                        if (strpos($rule, 'unique')) {
                            $rule = substr($rule, 0, strpos($rule, 'unique') + 6);
                        } elseif (strpos($rule, 'exists')) {
                            $rule = substr($rule, 0, strpos($rule, 'exists') - 1);
                        }
                    }
                }
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
        $errors = [];
        foreach (\Module::all() as $module) {
            $nameSpace = 'App\\Modules\\' . $module['basename'] ;
            $class = $nameSpace . '\\Errors\\'  . $module['basename'] . 'Errors';
            $reflectionClass = new \ReflectionClass($class);
            foreach ($reflectionClass->getMethods() as $method) {
                $methodName       = $method->name;
                $reflectionMethod = $reflectionClass->getMethod($methodName);
                $body             = $this->getMethodBody($reflectionMethod);

                preg_match('/\$error=\[\'status\'=>([^#]+)\,/iU', $body, $match);

                if (count($match)) {
                    $errors[$match[1]][] = $methodName;
                }
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
    protected function getModels($modelName, &$docData, $reflectionClass)
    {
        if ($modelName && ! Arr::has($docData['models'], $modelName)) {
            $modelClass = get_class(call_user_func_array("\Core::{$modelName}", [])->model);
            $model      = factory($modelClass)->make();

            $property = $reflectionClass->getProperty('modelResource');
            $property->setAccessible(true);
            $modelResource = $property->getValue(\App::make($reflectionClass->getName()));
            $modelResource = new $modelResource($model);
            $modelArr      = $modelResource->toArray([]);

            foreach ($modelArr as $key => $attr) {
                if (is_object($attr) && property_exists($attr, 'resource') && $attr->resource instanceof \Illuminate\Http\Resources\MissingValue) {
                    unset($modelArr[$key]);
                }
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
        $relations = Arr::has($config['relations'], $modelName) ? Arr::has($config['relations'][$modelName], $method) ? $config['relations'][$modelName] : false : false;
        $modelName = call_user_func_array("\Core::{$returnDocBlock}", []) ? $returnDocBlock : $modelName;

        return $relations ? [$modelName => $relations && $relations[$method] ? $relations[$method] : []] : false;
    }
}
