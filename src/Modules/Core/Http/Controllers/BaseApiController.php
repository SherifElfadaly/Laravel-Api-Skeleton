<?php

namespace App\Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Modules\Core\Http\Resources\General as GeneralResource;

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
        $this->repo = $repo;
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
     * @param  string  $sortBy The name of the column to sort by.
     * @param  boolean $desc   Sort ascending or descinding (1: desc, 0: asc).
     * @return \Illuminate\Http\Response
     */
    public function index($sortBy = 'created_at', $desc = 1)
    {
        return $this->modelResource::collection($this->repo->all($this->relations, $sortBy, $desc));
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
     * Paginate all records with relations from storage
     * that matche the given query.
     *
     * @param  string  $query   The search text.
     * @param  integer $perPage Number of rows per page default 15.
     * @param  string  $sortBy  The name of the column to sort by.
     * @param  boolean $desc    Sort ascending or descinding (1: desc, 0: asc).
     * @return \Illuminate\Http\Response
     */
    public function search($query = '', $perPage = 15, $sortBy = 'created_at', $desc = 1)
    {
        return $this->modelResource::collection($this->repo->search($query, $perPage, $this->relations, $sortBy, $desc));
    }

    /**
     * Fetch records from the storage based on the given
     * condition.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $sortBy The name of the column to sort by.
     * @param  boolean $desc   Sort ascending or descinding (1: desc, 0: asc).
     * @return \Illuminate\Http\Response
     */
    public function findby(Request $request, $sortBy = 'created_at', $desc = 1)
    {
        return $this->modelResource::collection($this->repo->findBy($request->all(), $this->relations, $sortBy, $desc));
    }

    /**
     * Fetch the first record from the storage based on the given
     * condition.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function first(Request $request)
    {
        return new $this->modelResource($this->repo->first($request->all(), $this->relations));
    }

    /**
     * Paginate all records with relations from storage.
     *
     * @param  integer $perPage Number of rows per page default 15.
     * @param  string  $sortBy  The name of the column to sort by.
     * @param  boolean $desc    Sort ascending or descinding (1: desc, 0: asc).
     * @return \Illuminate\Http\Response
     */
    public function paginate($perPage = 15, $sortBy = 'created_at', $desc = 1)
    {
        return $this->modelResource::collection($this->repo->paginate($perPage, $this->relations, $sortBy, $desc));
    }

    /**
     * Fetch all records with relations based on
     * the given condition from storage in pages.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  integer $perPage Number of rows per page default 15.
     * @param  string  $sortBy  The name of the column to sort by.
     * @param  boolean $desc    Sort ascending or descinding (1: desc, 0: asc).
     * @return \Illuminate\Http\Response
     */
    public function paginateby(Request $request, $perPage = 15, $sortBy = 'created_at', $desc = 1)
    {
        return $this->modelResource::collection($this->repo->paginateBy($request->all(), $perPage, $this->relations, $sortBy, $desc));
    }

    /**
     * Save the given model to storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        foreach ($this->validationRules as &$rule) {
            if (strpos($rule, 'exists') && ! strpos($rule, 'deleted_at,NULL')) {
                $rule .= ',deleted_at,NULL';
            }

            if ($request->has('id')) {
                $rule = str_replace('{id}', $request->get('id'), $rule);
            } else {
                $rule = str_replace(',{id}', '', $rule);
            }
        }
        
        $this->validate($request, $this->validationRules);

        return $this->modelResource::collection($this->repo->save($request->all()));
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
     * @param  \Illuminate\Http\Request  $request
     * @param  integer $perPage Number of rows per page default 15.
     * @param  string  $sortBy  The name of the column to sort by.
     * @param  boolean $desc    Sort ascending or descinding (1: desc, 0: asc).
     * @return \Illuminate\Http\Response
     */
    public function deleted(Request $request, $perPage = 15, $sortBy = 'created_at', $desc = 1)
    {
        return $this->modelResource::collection($this->repo->deleted($request->all(), $perPage, $sortBy, $desc));
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
            $permission       = $permission !== 'index' ? $permission : 'list';
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
