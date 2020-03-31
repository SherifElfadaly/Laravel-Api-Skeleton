<?php

namespace App\Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Routing\Router as Route;
use Illuminate\Auth\AuthManager as Auth;
use \Illuminate\Auth\Middleware\Authenticate as AuthMiddleware;
use App\Modules\Users\Services\UserService;
use Illuminate\Support\Arr;

class CheckPermissions
{
    protected $route;
    protected $auth;
    protected $authMiddleware;
    protected $userService;
    protected $arr;
    
    /**
     * Init new object.
     *
     * @param   Route          $route
     * @param   Auth           $auth
     * @param   AuthMiddleware $authMiddleware
     * @param   UserService    $userService
     * @param   Arr            $arr
     *
     * @return  void
     */
    public function __construct(Route $route, Auth $auth, AuthMiddleware $authMiddleware, UserService $userService, Arr $arr)
    {
        $this->route = $route;
        $this->auth = $auth;
        $this->authMiddleware = $authMiddleware;
        $this->userService = $userService;
        $this->arr = $arr;
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
        $routeActions        = explode('@', $this->route->currentRouteAction());
        $reflectionClass     = new \ReflectionClass($routeActions[0]);
        $classProperties     = $reflectionClass->getDefaultProperties();
        $skipPermissionCheck = $this->arr->get($classProperties, 'skipPermissionCheck', []);
        $skipLoginCheck      = $this->arr->get($classProperties, 'skipLoginCheck', []);
        $modelName           = explode('\\', $routeActions[0]);
        $modelName           = lcfirst(str_replace('Controller', '', end($modelName)));
        $permission          = $routeActions[1];

        $this->auth->shouldUse('api');
        if (! in_array($permission, $skipLoginCheck)) {
            $this->authMiddleware->handle($request, function ($request) use ($modelName, $skipPermissionCheck, $skipLoginCheck, $permission) {
                $user             = $this->auth->user();
                $isPasswordClient = $user->token()->client->password_client;
    
                if ($user->blocked) {
                    \Errors::userIsBlocked();
                }
    
                if ($isPasswordClient && (in_array($permission, $skipPermissionCheck) || $this->userService->can($permission, $modelName))) {
                } elseif (! $isPasswordClient && $user->tokenCan($modelName.'-'.$permission)) {
                } else {
                    \Errors::noPermissions();
                }
            });
        }

        return $next($request);
    }
}
