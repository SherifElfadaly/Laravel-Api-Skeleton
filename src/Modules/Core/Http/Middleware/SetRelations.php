<?php

namespace App\Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Routing\Router as Route;

class SetRelations
{
    protected $arr;
    protected $route;
    
    /**
     * Init new object.
     *
     * @param   Route  $route
     * @param   Arr    $arr
     *
     * @return  void
     */
    public function __construct(Route $route, Arr $arr)
    {
        $this->arr = $arr;
        $this->route = $route;
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
        $relations          = $this->arr->get(config('core.relations'), $modelName, false);
        $request->relations = $relations && isset($relations[$route]) ? $relations[$route] : [];

        return $next($request);
    }
}
