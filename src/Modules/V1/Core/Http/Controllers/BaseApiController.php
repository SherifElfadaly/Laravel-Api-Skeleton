<?php
namespace App\Modules\V1\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseApiController extends Controller
{
    /**
     * The model implementation.
     * 
     * @var model
     */
    protected $model;

    /**
     * The config implementation.
     * 
     * @var config
     */
    protected $config;

    public function __construct()
    {
        \Session::put('timeZoneDiff', \Request::header('time-zone-diff') ?: 0);

        $locale = \Request::header('locale');
        switch ($locale) 
        {
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
        
        $this->config              = \CoreConfig::getConfig();
        $this->model               = property_exists($this, 'model') ? $this->model : false;
        $this->validationRules     = property_exists($this, 'validationRules') ? $this->validationRules : false;
        $this->skipPermissionCheck = property_exists($this, 'skipPermissionCheck') ? $this->skipPermissionCheck : [];
        $this->skipLoginCheck      = property_exists($this, 'skipLoginCheck') ? $this->skipLoginCheck : [];
        $this->relations           = array_key_exists($this->model, $this->config['relations']) ? $this->config['relations'][$this->model] : false;
        $route                     = explode('@',\Route::currentRouteAction())[1];
        $this->checkPermission($route);
    }

    /**
     * Fetch all records with relations from model repository.
     * 
     * @param  string  $sortBy
     * @param  boolean $desc
     * @return \Illuminate\Http\Response
     */
    public function index($sortBy = 'created_at', $desc = 1) 
    {
        if ($this->model)
        {
            $relations = $this->relations && $this->relations['all'] ? $this->relations['all'] : [];
            return \Response::json(call_user_func_array("\Core::{$this->model}", [])->all($relations, $sortBy, $desc), 200);
        }
    }

    /**
     * Fetch the single object with relations from model repository.
     * 
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function find($id) 
    {
        if ($this->model) 
        {
            $relations = $this->relations && $this->relations['find'] ? $this->relations['find'] : [];
            return \Response::json(call_user_func_array("\Core::{$this->model}", [])->find($id, $relations), 200);
        }
    }

    /**
     * Paginate all records with relations from model repository
     * that matche the given query.
     * 
     * @param  string  $query
     * @param  integer $perPage
     * @param  string  $sortBy
     * @param  boolean $desc
     * @return \Illuminate\Http\Response
     */
    public function search($query = '', $perPage = 15, $sortBy = 'created_at', $desc = 1) 
    {
        if ($this->model) 
        {
            $relations = $this->relations && $this->relations['search'] ? $this->relations['search'] : [];
            return \Response::json(call_user_func_array("\Core::{$this->model}", [])->search($query, $perPage, $relations, $sortBy, $desc), 200);
        }
    }

    /**
     * Fetch records from the storage based on the given
     * condition.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $sortBy
     * @param  boolean $desc
     * @return \Illuminate\Http\Response
     */
    public function findby(Request $request, $sortBy = 'created_at', $desc = 1) 
    {
        if ($this->model) 
        {
            $relations = $this->relations && $this->relations['findBy'] ? $this->relations['findBy'] : [];
            return \Response::json(call_user_func_array("\Core::{$this->model}", [])->findBy($request->all(), $relations, $sortBy, $desc), 200);
        }
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
        if ($this->model) 
        {
            $relations = $this->relations && $this->relations['first'] ? $this->relations['first'] : [];
            return \Response::json(call_user_func_array("\Core::{$this->model}", [])->first($request->all(), $relations), 200);
        }
    }

    /**
     * Paginate all records with relations from model repository.
     * 
     * @param  integer $perPage
     * @param  string  $sortBy
     * @param  boolean $desc
     * @return \Illuminate\Http\Response
     */
    public function paginate($perPage = 15, $sortBy = 'created_at', $desc = 1) 
    {
        if ($this->model) 
        {
            $relations = $this->relations && $this->relations['paginate'] ? $this->relations['paginate'] : [];
            return \Response::json(call_user_func_array("\Core::{$this->model}", [])->paginate($perPage, $relations, $sortBy, $desc), 200);
        }
    }

    /**
     * Fetch all records with relations based on
     * the given condition from storage in pages.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  integer $perPage
     * @param  string  $sortBy
     * @param  boolean $desc
     * @return \Illuminate\Http\Response
     */
    public function paginateby(Request $request, $perPage = 15, $sortBy = 'created_at', $desc = 1) 
    {
        if ($this->model) 
        {
            $relations = $this->relations && $this->relations['paginateBy'] ? $this->relations['paginateBy'] : [];
            return \Response::json(call_user_func_array("\Core::{$this->model}", [])->paginateBy($request->all(), $perPage, $relations, $sortBy, $desc), 200);
        }
    }

    /**
     * Save the given model to repository.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request) 
    {
        foreach ($this->validationRules as &$rule) 
        {
            if (strpos($rule, 'exists') && ! strpos($rule, 'deleted_at,NULL')) 
            {
                $rule .= ',deleted_at,NULL';
            }

            if ($request->has('id')) 
            {
                $rule = str_replace('{id}', $request->get('id'), $rule);
            }
            else
            {
                $rule = str_replace(',{id}', '', $rule);
            }
        }
        
        $this->validate($request, $this->validationRules);

        if ($this->model) 
        {
            return \Response::json(call_user_func_array("\Core::{$this->model}", [])->save($request->all()), 200);
        }
    }

    /**
     * Delete by the given id from model repository.
     * 
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id) 
    {
        if ($this->model) 
        {
            return \Response::json(call_user_func_array("\Core::{$this->model}", [])->delete($id), 200);
        }
    }

    /**
     * Return the deleted models in pages based on the given conditions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  integer $perPage
     * @param  string  $sortBy
     * @param  boolean $desc
     * @return \Illuminate\Http\Response
     */
    public function deleted(Request $request, $perPage = 15, $sortBy = 'created_at', $desc = 1) 
    {
        return \Response::json(call_user_func_array("\Core::{$this->model}", [])->deleted($request->all(), $perPage, $sortBy, $desc), 200);
    }

    /**
     * Restore the deleted model.
     * 
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id) 
    {
        if ($this->model) 
        {
            return \Response::json(call_user_func_array("\Core::{$this->model}", [])->restore($id), 200);
        }
    }

    /**
     * Check if the logged in user can do the given permission.
     * 
     * @param  string $permission
     * @return void
     */
    private function checkPermission($permission)
    {
        $permission = $permission !== 'index' ? $permission : 'list';
        if ( ! in_array($permission, $this->skipLoginCheck)) 
        {
            $user = \Core::users()->find(\JWTAuth::parseToken()->authenticate()->id);
            if ($user->blocked)
            {
                \ErrorHandler::userIsBlocked();
            }
            
            if ( ! in_array($permission, $this->skipPermissionCheck) && ! \Core::users()->can($permission, $this->model))
            {
                \ErrorHandler::noPermissions();
            }
        }
    }
}
