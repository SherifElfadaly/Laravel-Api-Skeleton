<?php

namespace App\Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Routing\Router as Route;
use App\Modules\Core\Utl\CoreConfig as Config;

class SetRelations
{
    protected $arr;
    protected $route;
    protected $config;
    
    /**
     * Init new object.
     *
     * @param   Route  $route
     * @param   Arr    $arr
     * @param   Config $config
     *
     * @return  void
     */
    public function __construct(Route $route, Arr $arr, Config $config)
    {
        $this->arr = $arr;
        $this->route = $route;
        $this->config = $config->getConfig();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $routeActions       = explode('@', $this->route->currentRouteAction());
        $modelName          = explode('\\', $routeActions[0]);
        $modelName          = lcfirst(str_replace('Controller', '', end($modelName)));
        $route              = explode('@', $this->route->currentRouteAction())[1];
        $route              = $route !== 'index' ? $route : 'list';
        $relations          = $this->arr->get($this->config['relations'], $modelName, false);
        $request->relations = $relations && isset($relations[$route]) ? $relations[$route] : [];

        return $next($request);
    }
}
