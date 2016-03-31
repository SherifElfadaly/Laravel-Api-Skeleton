<?php
namespace App\Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Core\ErrorHandler;
use App\Modules\Core\CoreConfig;


class BaseApiController extends Controller
{
    /**
     * The errorHandler implementation.
     * 
     * @var errorHandler
     */
    protected $errorHandler;

    /**
     * The config implementation.
     * 
     * @var config
     */
    protected $config;

    /**
     * The model implementation.
     * 
     * @var model
     */
    protected $model;

    /**
     * Create new BaseApiController instance.
     * 
     * @param errorHandler
     */
    public function __construct(ErrorHandler $errorHandler, CoreConfig $config)
    {
        \Session::set('timeZoneDiff', \Request::header('time-zone-diff') ?: 0);
        
        $this->errorHandler        = $errorHandler;
        $this->config              = $config->getConfig();
        
        $this->model               = property_exists($this, 'model') ? $this->model : false;
        $this->validationRules     = property_exists($this, 'validationRules') ? $this->validationRules : false;
        $this->skipPermissionCheck = property_exists($this, 'skipPermissionCheck') ? $this->skipPermissionCheck : [];
        $this->skipLoginCheck      = property_exists($this, 'skipLoginCheck') ? $this->skipLoginCheck : [];
        
        $this->relations           = array_key_exists($this->model, $this->config['relations']) ? $this->config['relations'][$this->model] : false;
        $route                     = explode('@',\Route::currentRouteAction())[1];
        $this->checkPermission(explode('_', snake_case($route))[1]);
    }

    /**
     * Fetch all records with relations from model repository.
     * 
     * @param  string  $sortBy
     * @param  boolean $desc
     * @return \Illuminate\Http\Response
     */
    public function getIndex() 
    {
        if ($this->model)
        {
            $relations = $this->relations && $this->relations['all'] ? $this->relations['all'] : [];
            return \Response::json(call_user_func_array("\Core::{$this->model}", [])->all($relations), 200);
        }
    }

    /**
     * Fetch the single object with relations from model repository.
     * 
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function getFind($id) 
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
    public function getSearch($query = '', $perPage = 15, $sortBy = 'created_at', $desc = 1) 
    {
        if ($this->model) 
        {
            $relations = $this->relations && $this->relations['paginate'] ? $this->relations['paginate'] : [];
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
    public function postFindby(Request $request, $sortBy = 'created_at', $desc = 1) 
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
    public function postFirst(Request $request) 
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
    public function getPaginate($perPage = 15, $sortBy = 'created_at', $desc = 1) 
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
    public function postPaginateby(Request $request, $perPage = 15, $sortBy = 'created_at', $desc = 1) 
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
    public function postSave(Request $request) 
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
    public function getDelete($id) 
    {
        if ($this->model) 
        {
            return \Response::json(call_user_func_array("\Core::{$this->model}", [])->delete($id), 200);
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
        if ($permission == 'method') 
        {
            $error = $this->errorHandler->notFound('method');
            abort($error['status'], $error['message']);
        }
        else if ( ! in_array($permission, $this->skipLoginCheck)) 
        {
            \JWTAuth::parseToken()->authenticate();
            if ( ! in_array($permission, $this->skipPermissionCheck) && ! \Core::users()->can($permission, $this->model))
            {
                $error = $this->errorHandler->noPermissions();
                abort($error['status'], $error['message']);
            }
        }
    }
}
