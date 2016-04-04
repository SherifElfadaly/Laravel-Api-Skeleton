<?php namespace App\Modules\Core\AbstractRepositories;

use App\Modules\Core\Interfaces\RepositoryInterface;

abstract class AbstractRepository implements RepositoryInterface
{
    /**
     * The model implementation.
     * 
     * @var model
     */
    public $model;
    
    /**
     * Create new AbstractRepository instance.
     */
    public function __construct()
    {   
        $this->config = \CoreConfig::getConfig();
        $this->model  = \App::make($this->getModel());
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
        $sort = $desc ? 'desc' : 'asc';
        return call_user_func_array("{$this->getModel()}::with", array($relations))->orderBy($sortBy, $sort)->get($columns);
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
        $model            = call_user_func_array("{$this->getModel()}::with", array($relations));
        $conditionColumns = $this->model->getFillable();
        $sort             = $desc ? 'desc' : 'asc';

        $model->where(function ($q) use ($query, $conditionColumns, $relations){
            $q->where(\DB::raw('LOWER(CAST(' . array_shift($conditionColumns) . ' AS TEXT))'), 'LIKE', '%' . strtolower($query) . '%');
            foreach ($conditionColumns as $column) 
            {
                $q->orWhere(\DB::raw('LOWER(CAST(' . $column . ' AS TEXT))'), 'LIKE', '%' . strtolower($query) . '%');
            }
            foreach ($relations as $relation) 
            {
                $relation = explode('.', $relation)[0];
                if (\Core::$relation()) 
                {
                    $q->orWhereHas($relation, function ($subModel) use ($query, $relation){

                        $subModel->where(function ($q) use ($query, $relation){

                            $subConditionColumns = \Core::$relation()->model->getFillable();
                            $q->where(\DB::raw('LOWER(CAST(' . array_shift($subConditionColumns) . ' AS TEXT))'), 'LIKE', '%' . strtolower($query) . '%');
                            foreach ($subConditionColumns as $column)
                            {
                                $q->orWhere(\DB::raw('LOWER(CAST(' . $column . ' AS TEXT))'), 'LIKE', '%' . strtolower($query) . '%');
                            } 
                        });

                    });
                }
            }
        });
        
        return $model->orderBy($sortBy, $sort)->paginate($perPage, $columns);
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
        $sort = $desc ? 'desc' : 'asc';
        return call_user_func_array("{$this->getModel()}::with", array($relations))->orderBy($sortBy, $sort)->paginate($perPage, $columns);
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
        unset($conditions['page']);
        $conditions = $this->constructConditions($conditions);
        $sort       = $desc ? 'desc' : 'asc';
        return call_user_func_array("{$this->getModel()}::with", array($relations))->whereRaw($conditions['conditionString'], $conditions['conditionValues'])->orderBy($sortBy, $sort)->paginate($perPage, $columns);
    }
    
    /**
     * Save the given model to the storage.
     * 
     * @param  array   $data
     * @param  boolean $saveLog
     * @return object
     */
    public function save(array $data, $saveLog = true)
    {
        $model      = false;
        $modelClass = $this->model;
        $relations  = [];
        $with       = [];

        \DB::transaction(function () use (&$model, &$relations, &$with, $data, $saveLog, $modelClass) {
            /**
             * If the id is present in the data then select the model for updating,
             * else create new model.
             * @var array
             */
            $model = array_key_exists('id', $data) ? $modelClass->lockForUpdate()->find($data['id']) : new $modelClass;
            if ( ! $model) 
            {
                $error = \ErrorHandler::notFound(class_basename($modelClass) . ' with id : ' . $data['id']);
                abort($error['status'], $error['message']);
            }

            /**
             * Construct the model object with the given data,
             * and if there is a relation add it to relations array,
             * then save the model.
             */
            foreach ($data as $key => $value) 
            {
                $relation = camel_case($key);
                if (method_exists($model, $relation))
                {
                    $with[] = $relation;
                    if (class_basename($model->$relation) == 'Collection') 
                    {   
                        if ( ! $value || ! count($value)) 
                        {
                            $relations[$relation] = 'delete';
                        }   
                    }
                    if (is_array($value)) 
                    {
                        foreach ($value as $attr => $val) 
                        {
                            $relationBaseModel = \Core::$relation()->model;
                            if (class_basename($model->$relation) == 'Collection')
                            {
                                $relationModel = array_key_exists('id', $val) ? $relationBaseModel->lockForUpdate()->find($val['id']) : new $relationBaseModel;
                                if ( ! $relationModel) 
                                {
                                    $error = \ErrorHandler::notFound(class_basename($relationBaseModel) . ' with id : ' . $val['id']);
                                    abort($error['status'], $error['message']);
                                }

                                foreach ($val as $attr => $val) 
                                {
                                    if (gettype($val) !== 'object' && gettype($val) !== 'array' &&  array_search($attr, $relationModel->getFillable(), true) !== false)
                                    {
                                        $relationModel->$attr = $val;
                                    }
                                }
                                $relations[$relation][] = $relationModel;
                            }
                            else
                            {
                                if (gettype($val) !== 'object' && gettype($val) !== 'array') 
                                {
                                    $relationModel = array_key_exists('id', $value) ? $relationBaseModel->lockForUpdate()->find($value['id']) : new $relationBaseModel;
                                    if ( ! $relationModel) 
                                    {
                                        $error = \ErrorHandler::notFound(class_basename($relationBaseModel) . ' with id : ' . $value['id']);
                                        abort($error['status'], $error['message']);
                                    }

                                    if (array_search($attr, $relationModel->getFillable(), true) !== false) 
                                    {
                                        $relationModel->$attr = $val;
                                        $relations[$relation] = $relationModel;
                                    }
                                }
                            }
                        }
                    }
                }
                else if (array_search($key, $model->getFillable(), true) !== false)
                {
                    $model->$key = $value;   
                }
            }
            $model->save();
            
            foreach ($relations as $key => $value) 
            {
                if ($value == 'delete' && $model->$key()->count())
                {
                    $model->$key()->delete();
                }
                else if (gettype($value) == 'array') 
                {
                    $ids = [];
                    foreach ($value as $val) 
                    {
                        switch (class_basename($model->$key())) 
                        {
                            case 'HasMany':
                                $foreignKeyName       = explode('.', $model->$key()->getForeignKey())[1];
                                $val->$foreignKeyName = $model->id;
                                $val->save();
                                $ids[] = $val->id;
                                break;

                            case 'BelongsToMany':
                                $val->save();
                                $ids[] = $val->id;
                                break;
                        }
                    }
                    switch (class_basename($model->$key())) 
                    {
                        case 'HasMany':
                            $model->$key()->whereNotIn('id', $ids)->delete();
                            break;

                        case 'BelongsToMany':
                            $model->$key()->detach();
                            $model->$key()->attach($ids);
                            break;
                    }
                }
                else
                {
                    switch (class_basename($model->$key())) 
                    {
                        case 'BelongsTo':
                            $value->save();
                            $model->$key()->associate($value);
                            $model->save();
                            break;
                    }
                }
            }
            $saveLog ? \Logging::saveLog(array_key_exists('id', $data) ? 'update' : 'create', class_basename($modelClass), $this->getModel(), $model->id, $model) : false;
        });
        
        $this->afterSave($model, $relations);

        return $this->find($model->id, $with);
    }

    /**
     * Save the given models to the storage.
     * 
     * @param  array   $data
     * @return object
     */
    public function saveMany(array $data)
    {
        $result = [];
        \DB::transaction(function () use (&$result, $data) {
            foreach ($data as $key => $value) 
            {
                $result[] = $this->save($value);
            }
        });
        return $result;
    }
    
    /**
     * Update record in the storage based on the given
     * condition.
     * 
     * @param  [type] $value condition value
     * @param  array $data
     * @param  string $attribute condition column name
     * @return void
     */
    public function update($value, array $data, $attribute = 'id', $saveLog = true)
    {
        if ($attribute == 'id') 
        {
            $model = $this->model->lockForUpdate()->find($value);
            $model ? $model->update($data) : 0;
            $saveLog ? \Logging::saveLog('update', class_basename($this->model), $this->getModel(), $value, $model) : false;
        }
    	call_user_func_array("{$this->getModel()}::where", array($attribute, '=', $value))->lockForUpdate()->get()->each(function ($model) use ($data, $saveLog){
            $model->update($data);
            $saveLog ? \Logging::saveLog('update', class_basename($this->model), $this->getModel(), $model->id, $model) : false;
        });
    }
    
    /**
     * Delete record from the storage based on the given
     * condition.
     * 
     * @param  [type] $value condition value
     * @param  string $attribute condition column name
     * @return void
     */
    public function delete($value, $attribute = 'id', $saveLog = true)
    {
    	if ($attribute == 'id') 
    	{
            \DB::transaction(function () use ($value, $attribute, &$result, $saveLog) {
                $model = $this->model->lockForUpdate()->find($value);
                $model->delete();
                $saveLog ? \Logging::saveLog('delete', class_basename($this->model), $this->getModel(), $value, $model) : false;
            });
    	}
        else
        {
            \DB::transaction(function () use ($value, $attribute, &$result, $saveLog) {
                call_user_func_array("{$this->getModel()}::where", array($attribute, '=', $value))->lockForUpdate()->get()->each(function ($model){
                    $model->delete();
                    $saveLog ? \Logging::saveLog('delete', class_basename($this->model), $this->getModel(), $model->id, $model) : false;
                });
            });   
        }
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
        return call_user_func_array("{$this->getModel()}::with", array($relations))->find($id, $columns);
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
        $conditions = $this->constructConditions($conditions);
        $sort       = $desc ? 'desc' : 'asc';
        return call_user_func_array("{$this->getModel()}::with",  array($relations))->whereRaw($conditions['conditionString'], $conditions['conditionValues'])->orderBy($sortBy, $sort)->get($columns);
    }

    /**
     * Fetch the first record from the storage based on the given
     * condition.
     *
     * @param  array   $conditions array of conditions
     * @param  array   $relations
     * @param  array   $colunmns
     * @return object
     */
    public function first($conditions, $relations = [], $columns = array('*'))
    {
        $conditions = $this->constructConditions($conditions);
        return call_user_func_array("{$this->getModel()}::with", array($relations))->whereRaw($conditions['conditionString'], $conditions['conditionValues'])->first($columns);  
    }

    /**
     * Build the conditions recursively for the retrieving methods.
     * @param  array $conditions
     * @return array
     */
    protected function constructConditions($conditions)
    {   
        $conditionString = '';
        $conditionValues = [];
        foreach ($conditions as $key => $value) 
        {
            if ($key == 'and') 
            {
                $conditionString  .= str_replace('{op}', 'and', $this->constructConditions($value)['conditionString']) . ' {op} ';
                $conditionValues   = array_merge($conditionValues, $this->constructConditions($value)['conditionValues']);
            }
            else if ($key == 'or')
            {
                $conditionString  .= str_replace('{op}', 'or', $this->constructConditions($value)['conditionString']) . ' {op} ';
                $conditionValues   = array_merge($conditionValues, $this->constructConditions($value)['conditionValues']);
            }
            else
            {
                $conditionString  .= $key . '=? {op} ';
                $conditionValues[] = $value;
            }
        }
        $conditionString = '(' . rtrim($conditionString, '{op} ') . ')';
        return ['conditionString' => $conditionString, 'conditionValues' => $conditionValues];
    }

    /**
     * Abstract method that is called in after
     * the save method finish.
     * 
     * @param  object  $model
     * @param  array   $relations
     * @return void
     */
    protected function afterSave($model, $relations)
    {
        return false;
    }

    /**
     * Abstract method that return the necessary 
     * information (full model namespace)
     * needed to preform the previous actions.
     * 
     * @return string
     */
    abstract protected function getModel();
}