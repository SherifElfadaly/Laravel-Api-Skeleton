<?php namespace App\Modules\V1\Core\Decorators;

use App\Modules\V1\Core\Interfaces\RepositoryInterface;

class CachingDecorator implements RepositoryInterface
{
    /**
     * The repo implementation.
     * 
     * @var repo
     */
    protected $repo;

    /**
     * The cache implementation.
     * 
     * @var cache
     */
    protected $cache;

    /**
     * The model implementation.
     * 
     * @var model
     */
    public $model;
    
    /**
     * Create new CachingDecorator instance.
     */
    public function __construct($repo, $cache)
    {   
        $this->repo  = $repo;
        $this->cache = $cache;
        $this->model = get_class($this->repo->model);
    }

    /**
     * Fetch all records with relations from the storage.
     *
     * @param  array   $relations
     * @param  string  $sortBy
     * @param  boolean $desc
     * @param  array   $columns
     * @return collection
     */
    public function all($relations = [], $sortBy = 'created_at', $desc = 1, $columns = array('*'))
    {
        $cacheKey = 'all';
        return $this->cache->tags([$this->model])->rememberForever($cacheKey, function() use ($relations, $sortBy, $desc, $columns) {
            return $this->repo->all($relations, $sortBy, $desc, $columns);
        });
    }

    /**
     * Fetch all records with relations from storage in pages 
     * that matche the given query.
     * 
     * @param  string  $query
     * @param  integer $perPage
     * @param  array   $relations
     * @param  string  $sortBy
     * @param  boolean $desc
     * @param  array   $columns
     * @return collection
     */
    public function search($query, $perPage = 15, $relations = [], $sortBy = 'created_at', $desc = 1, $columns = array('*'))
    {
        $page     = \Request::get('page') ?? '1';
        $cacheKey = 'search.' . $perPage . '.' . $query . '.' . $page;
        return $this->cache->tags([$this->model])->rememberForever($cacheKey, function() use ($query, $perPage, $relations, $sortBy, $desc, $columns) {
            return $this->repo->search($query, $perPage, $relations, $sortBy, $desc, $columns);
        });
    }
    
    /**
     * Fetch all records with relations from storage in pages.
     * 
     * @param  integer $perPage
     * @param  array   $relations
     * @param  string  $sortBy
     * @param  boolean $desc
     * @param  array   $columns
     * @return collection
     */
    public function paginate($perPage = 15, $relations = [], $sortBy = 'created_at', $desc = 1, $columns = array('*'))
    {
        $page     = \Request::get('page') ?? '1';
        $cacheKey = 'paginate.' . $perPage . '.' . $page;
        return $this->cache->tags([$this->model])->rememberForever($cacheKey, function() use ($perPage, $relations, $sortBy, $desc, $columns) {
            return $this->repo->paginate($perPage, $relations, $sortBy, $desc, $columns);
        });
    }

    /**
     * Fetch all records with relations based on
     * the given condition from storage in pages.
     * 
     * @param  array   $conditions array of conditions
     * @param  integer $perPage
     * @param  array   $relations
     * @param  string  $sortBy
     * @param  boolean $desc
     * @param  array   $columns
     * @return collection
     */
    public function paginateBy($conditions, $perPage = 15, $relations = [], $sortBy = 'created_at', $desc = 1, $columns = array('*'))
    {
        $page     = \Request::get('page') ?? '1';
        $cacheKey = 'paginateBy.' . $perPage . '.' .  $page . '.' . serialize($conditions);
        return $this->cache->tags([$this->model])->rememberForever($cacheKey, function() use ($conditions, $perPage, $relations, $sortBy, $desc, $columns) {
            return $this->repo->paginateBy($conditions, $perPage, $relations, $sortBy, $desc, $columns);
        });
    }
    
    /**
     * Save the given model to the storage.
     * 
     * @param  array   $data
     * @param  boolean $saveLog
     * @return void
     */
    public function save(array $data, $saveLog = true)
    {
        $this->cache->tags([$this->model])->flush();
        return $this->repo->save($data, $saveLog);
    }
    
    /**
     * Update record in the storage based on the given
     * condition.
     * 
     * @param  var $value condition value
     * @param  array $data
     * @param  string $attribute condition column name
     * @return void
     */
    public function update($value, array $data, $attribute = 'id', $saveLog = true)
    {
        $this->cache->tags([$this->model])->flush();
        return $this->repo->update($value, $data, $attribute, $saveLog);
    }

    /**
     * Delete record from the storage based on the given
     * condition.
     * 
     * @param  var $value condition value
     * @param  string $attribute condition column name
     * @return void
     */
    public function delete($value, $attribute = 'id', $saveLog = true)
    {
        $this->cache->tags([$this->model])->flush();
        return $this->repo->delete($value, $attribute, $saveLog);
    }
    
    /**
     * Fetch records from the storage based on the given
     * id.
     * 
     * @param  integer $id
     * @param  array   $relations
     * @param  array   $columns
     * @return object
     */
    public function find($id, $relations = [], $columns = array('*'))
    {
        $cacheKey = 'find.' . $id;
        return $this->cache->tags([$this->model])->rememberForever($cacheKey, function() use ($id, $relations, $columns) {
            return $this->repo->find($id, $relations, $columns);
        });
    }
    
    /**
     * Fetch records from the storage based on the given
     * condition.
     * 
     * @param  array   $conditions array of conditions
     * @param  array   $relations
     * @param  string  $sortBy
     * @param  boolean $desc
     * @param  array   $columns
     * @return collection
     */
    public function findBy($conditions, $relations = [], $sortBy = 'created_at', $desc = 1, $columns = array('*'))
    {
        $cacheKey = 'findBy.' . serialize($conditions);
        return $this->cache->tags([$this->model])->rememberForever($cacheKey, function() use ($conditions, $relations, $sortBy, $desc, $columns) {
            return $this->repo->findBy($conditions, $relations, $sortBy, $desc, $columns);
        });
    }

    /**
     * Fetch the first record from the storage based on the given
     * condition.
     *
     * @param  array   $conditions array of conditions
     * @param  array   $relations
     * @param  array   $columns
     * @return object
     */
    public function first($conditions, $relations = [], $columns = array('*'))
    {
        $cacheKey = 'first.' . serialize($conditions);
        return $this->cache->tags([$this->model])->rememberForever($cacheKey, function() use ($conditions, $relations, $columns) {
            return $this->repo->first($conditions, $relations, $columns);
        });  
    }

    /**
     * Return the deleted models in pages based on the given conditions.
     * 
     * @param  array   $conditions array of conditions
     * @param  integer $perPage
     * @param  string  $sortBy
     * @param  boolean $desc
     * @param  array   $columns
     * @return collection
     */
    public function deleted($conditions, $perPage = 15, $sortBy = 'created_at', $desc = 1, $columns = array('*'))
    {
        $page     = \Request::get('page') ?? '1';
        $cacheKey = 'deleted.' . $perPage . '.' .  $page . '.' . serialize($conditions);
        return $this->cache->tags([$this->model])->rememberForever($cacheKey, function() use ($conditions, $perPage, $sortBy, $desc, $columns) {
            return $this->repo->deleted($conditions, $perPage, $sortBy, $desc, $columns);
        });
    }

    /**
     * Restore the deleted model.
     * 
     * @param  integer $id
     * @return void
     */
    public function restore($id)
    {
        $this->cache->tags([$this->model])->flush();
        return $this->repo->restore($id);
    }

    /**
     * Handle calling methods that is not implemented in the 
     * abstract repository.
     * 
     * @param  string $name the called method name
     * @param  array  $arguments the method arguments
     * @return object
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->repo, $name], $arguments);
    }
}