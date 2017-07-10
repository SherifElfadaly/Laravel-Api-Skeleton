<?php
namespace App\Modules\V1\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
     * @var array
     */
    protected $repo;

    public function __construct()
    {        
        $this->config              = \CoreConfig::getConfig();
        $this->model               = property_exists($this, 'model') ? $this->model : false;
        $this->validationRules     = property_exists($this, 'validationRules') ? $this->validationRules : false;
        $this->skipPermissionCheck = property_exists($this, 'skipPermissionCheck') ? $this->skipPermissionCheck : [];
        $this->skipLoginCheck      = property_exists($this, 'skipLoginCheck') ? $this->skipLoginCheck : [];
        $this->repo                = call_user_func_array("\Core::{$this->model}", []);
        $route                     = explode('@',\Route::currentRouteAction())[1];

        $this->checkPermission($route);
        $this->setRelations($route);
        $this->setSessions();
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
        if ($this->repo)
        {
            return \Response::json($this->repo->all($this->relations, $sortBy, $desc), 200);
        }
    }

    /**
     * Fetch the single object with relations from storage.
     * 
     * @param  integer $id Id of the requested model.
     * @return \Illuminate\Http\Response
     */
    public function find($id) 
    {
        if ($this->repo) 
        {
            return \Response::json($this->repo->find($id, $this->relations), 200);
        }
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
        if ($this->repo) 
        {
            return \Response::json($this->repo->search($query, $perPage, $this->relations, $sortBy, $desc), 200);
        }
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
        if ($this->repo) 
        {
            return \Response::json($this->repo->findBy($request->all(), $this->relations, $sortBy, $desc), 200);
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
        if ($this->repo) 
        {
            return \Response::json($this->repo->first($request->all(), $this->relations), 200);
        }
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
        if ($this->repo) 
        {
            return \Response::json($this->repo->paginate($perPage, $this->relations, $sortBy, $desc), 200);
        }
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
        if ($this->repo) 
        {
            return \Response::json($this->repo->paginateBy($request->all(), $perPage, $this->relations, $sortBy, $desc), 200);
        }
    }

    /**
     * Save the given model to storage.
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

        if ($this->repo) 
        {
            return \Response::json($this->repo->save($request->all()), 200);
        }
    }

    /**
     * Delete by the given id from storage.
     * 
     * @param  integer $id Id of the deleted model.
     * @return \Illuminate\Http\Response
     */
    public function delete($id) 
    {
        if ($this->repo) 
        {
            return \Response::json($this->repo->delete($id), 200);
        }
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
        return \Response::json($this->repo->deleted($request->all(), $perPage, $sortBy, $desc), 200);
    }

    /**
     * Restore the deleted model.
     * 
     * @param  integer $id Id of the restored model.
     * @return \Illuminate\Http\Response
     */
    public function restore($id) 
    {
        if ($this->repo) 
        {
            return \Response::json($this->repo->restore($id), 200);
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
            $user = \JWTAuth::parseToken()->authenticate();
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

    /**
     * Set sessions based on the given headers in the request.
     * 
     * @return void
     */
    private function setSessions()
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
        $relations       = array_key_exists($this->model, $this->config['relations']) ? $this->config['relations'][$this->model] : false;
        $this->relations = $relations && $relations[$route] ? $relations[$route] : [];
    }
}
