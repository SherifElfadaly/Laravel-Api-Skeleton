<?php

namespace App\Modules\Core\BaseClasses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Modules\Core\Http\Resources\General as GeneralResource;
use App\Modules\Core\Decorators\CachingDecorator;

class BaseApiController extends Controller
{
    /**
     * The config implementation.
     *
     * @var array
     */
    protected $config;

    /**
     * The relations implementation.
     *
     * @var array
     */
    protected $relations;

    /**
     * The repo implementation.
     *
     * @var object
     */
    protected $repo;

    /**
     * Init new object.
     *
     * @param   mixed      $repo
     * @param   CoreConfig $config
     * @param   string     $modelResource
     * @return  void
     */
    public function __construct($repo, $config, $modelResource)
    {
        $this->repo = new CachingDecorator($repo, \App::make('Illuminate\Contracts\Cache\Repository'));
        $this->modelResource = $modelResource;
        $this->config = $config->getConfig();
        $this->modelName = explode('\\', get_called_class());
        $this->modelName = lcfirst(str_replace('Controller', '', end($this->modelName)));
        $this->validationRules = property_exists($this, 'validationRules') ? $this->validationRules : false;
        $this->skipPermissionCheck = property_exists($this, 'skipPermissionCheck') ? $this->skipPermissionCheck : [];
        $this->skipLoginCheck = property_exists($this, 'skipLoginCheck') ? $this->skipLoginCheck : [];
        $route = explode('@', \Route::currentRouteAction())[1];

        $this->setSessions();
        $this->checkPermission($route);
        $this->setRelations($route);
    }

    /**
     * Fetch all records with relations from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->modelResource::collection($this->repo->list($this->relations, $request->query(), $request->query('perPage'), $request->query('sortBy'), $request->query('desc')));
    }

    /**
     * Fetch the single object with relations from storage.
     *
     * @param  integer $id Id of the requested model.
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        return new $this->modelResource($this->repo->find($id, $this->relations));
    }

    /**
     * Delete by the given id from storage.
     *
     * @param  integer $id Id of the deleted model.
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        return new GeneralResource($this->repo->delete($id));
    }

    /**
     * Return the deleted models in pages based on the given conditions.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function deleted(Request $request)
    {
        return $this->modelResource::collection($this->repo->deleted($request->all(), $request->query('perPage'), $request->query('sortBy'), $request->query('desc')));
    }

    /**
     * Restore the deleted model.
     *
     * @param  integer $id Id of the restored model.
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        return new GeneralResource($this->repo->restore($id));
    }

    /**
     * Check if the logged in user can do the given permission.
     *
     * @param  string $permission
     * @return void
     */
    private function checkPermission($permission)
    {
        \Auth::shouldUse('api');
        $this->middleware('auth:api', ['except' => $this->skipLoginCheck]);
        
        if (! in_array($permission, $this->skipLoginCheck) && $user = \Auth::user()) {
            $user             = \Auth::user();
            $isPasswordClient = $user->token()->client->password_client;
            $this->updateLocaleAndTimezone($user);

            if ($user->blocked) {
                \ErrorHandler::userIsBlocked();
            }

            if ($isPasswordClient && (in_array($permission, $this->skipPermissionCheck) || \Core::users()->can($permission, $this->modelName))) {
            } elseif (! $isPasswordClient && $user->tokenCan($this->modelName.'-'.$permission)) {
            } else {
                \ErrorHandler::noPermissions();
            }
        }
    }

    /**
     * Set sessions based on the given headers in the request.
     *
     * @return void
     */
    private function setSessions()
    {
        \Session::put('time-zone', \Request::header('time-zone') ?: 0);

        $locale = \Request::header('locale');
        switch ($locale) {
            case 'en':
                \App::setLocale('en');
                \Session::put('locale', 'en');
                break;

            case 'ar':
                \App::setLocale('ar');
                \Session::put('locale', 'ar');
                break;

            case 'all':
                \App::setLocale('en');
                \Session::put('locale', 'all');
                break;

            default:
                \App::setLocale('en');
                \Session::put('locale', 'en');
                break;
        }
    }

    /**
     * Set relation based on the called api.
     *
     * @param  string $route
     * @return void
     */
    private function setRelations($route)
    {
        $route           = $route !== 'index' ? $route : 'list';
        $relations       = Arr::get($this->config['relations'], $this->modelName, false);
        $this->relations = $relations && isset($relations[$route]) ? $relations[$route] : [];
    }

    /**
     * Update the logged in user locale and time zone.
     *
     * @param  object $user
     * @return void
     */
    private function updateLocaleAndTimezone($user)
    {
        $update   = false;
        $locale   = \Session::get('locale');
        $timezone = \Session::get('time-zone');
        if ($locale && $locale !== 'all' && $locale !== $user->locale) {
            $user->locale = $locale;
            $update       = true;
        }

        if ($timezone && $timezone !== $user->timezone) {
            $user->timezone = $timezone;
            $update       = true;
        }

        if ($update) {
            $user->save();
        }
    }
}
