<?php namespace App\Modules\V1\Core\AbstractRepositories;

use App\Modules\V1\Core\Interfaces\RepositoryInterface;

abstract class AbstractRepository implements RepositoryInterface
{
    /**
     * The model implementation.
     * 
     * @var model
     */
    public $model;
    
    /**
     * The config implementation.
     * 
     * @var config
     */
    protected $config;
    
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

        /**
         * Construct the select conditions for the model.
         */
        $model->where(function ($q) use ($query, $conditionColumns, $relations){

            /**
             * Use the first element in the model columns to construct the first condition.
             */
            $q->where(\DB::raw('LOWER(' . array_shift($conditionColumns) . ')'), 'LIKE', '%' . strtolower($query) . '%');

            /**
             * Loop through the rest of the columns to construct or where conditions.
             */
            foreach ($conditionColumns as $column) 
            {
                $q->orWhere(\DB::raw('LOWER(' . $column . ')'), 'LIKE', '%' . strtolower($query) . '%');
            }

            /**
             * Loop through the model relations.
             */
            foreach ($relations as $relation) 
            {
                /**
                 * Remove the sub relation if exists.
                 */
                $relation = explode('.', $relation)[0];

                /**
                 * Try to fetch the relation repository from the core.
                 */
                if (\Core::$relation()) 
                {
                    /**
                     * Construct the relation condition.
                     */
                    $q->orWhereHas($relation, function ($subModel) use ($query, $relation){

                        $subModel->where(function ($q) use ($query, $relation){

                            /**
                             * Get columns of the relation.
                             */
                            $subConditionColumns = \Core::$relation()->model->getFillable();

                            /**
                             * Use the first element in the relation model columns to construct the first condition.
                             */
                            $q->where(\DB::raw('LOWER(' . array_shift($subConditionColumns) . ')'), 'LIKE', '%' . strtolower($query) . '%');

                            /**
                             * Loop through the rest of the columns to construct or where conditions.
                             */
                            foreach ($subConditionColumns as $subConditionColumn)
                            {
                                $q->orWhere(\DB::raw('LOWER(' . $subConditionColumn . ')'), 'LIKE', '%' . strtolower($query) . '%');
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
                \ErrorHandler::notFound(class_basename($modelClass) . ' with id : ' . $data['id']);
            }

            /**
             * Construct the model object with the given data,
             * and if there is a relation add it to relations array,
             * then save the model.
             */
            foreach ($data as $key => $value) 
            {
                /**
                 * If the attribute is a relation.
                 */
                $relation = camel_case($key);
                if (method_exists($model, $relation))
                {
                    /**
                     * Add the relation to the with array to eager load the created model with the relations.
                     */
                    $with[] = $relation;

                    /**
                     * Check if the relation is a collection.
                     */
                    if (class_basename($model->$relation) == 'Collection') 
                    {   
                        /**
                         * If the relation has no value then marke the relation data 
                         * related to the model to be deleted.
                         */
                        if ( ! $value || ! count($value)) 
                        {
                            $relations[$relation] = 'delete';
                        }   
                    }
                    if (is_array($value)) 
                    {
                        /**
                         * Loop through the relation data.
                         */
                        foreach ($value as $attr => $val) 
                        {
                            /**
                             * Get the relation model.
                             */
                            $relationBaseModel = \Core::$relation()->model;

                            /**
                             * Check if the relation is a collection.
                             */
                            if (class_basename($model->$relation) == 'Collection')
                            {
                                /**
                                 * If the id is present in the data then select the relation model for updating,
                                 * else create new model.
                                 */
                                $relationModel = array_key_exists('id', $val) ? $relationBaseModel->lockForUpdate()->find($val['id']) : new $relationBaseModel;

                                /**
                                 * If model doesn't exists.
                                 */
                                if ( ! $relationModel) 
                                {
                                    \ErrorHandler::notFound(class_basename($relationBaseModel) . ' with id : ' . $val['id']);
                                }

                                /**
                                 * Loop through the relation attributes.
                                 */
                                foreach ($val as $attr => $val) 
                                {
                                    /**
                                     * Prevent the sub relations or attributes not in the fillable.
                                     */
                                    if (gettype($val) !== 'object' && gettype($val) !== 'array' &&  array_search($attr, $relationModel->getFillable(), true) !== false)
                                    {
                                        $relationModel->$attr = $val;
                                    }
                                }
                                $relations[$relation][] = $relationModel;
                            }
                            /**
                             * If not collection.
                             */
                            else
                            {
                                /**
                                 * Prevent the sub relations.
                                 */
                                if (gettype($val) !== 'object' && gettype($val) !== 'array') 
                                {
                                    /**
                                     * If the id is present in the data then select the relation model for updating,
                                     * else create new model.
                                     */
                                    $relationModel = array_key_exists('id', $value) ? $relationBaseModel->lockForUpdate()->find($value['id']) : new $relationBaseModel;

                                    /**
                                     * If model doesn't exists.
                                     */
                                    if ( ! $relationModel) 
                                    {
                                        \ErrorHandler::notFound(class_basename($relationBaseModel) . ' with id : ' . $value['id']);
                                    }

                                    /**
                                     * Prevent attributes not in the fillable.
                                     */
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
                /**
                 * If the attribute isn't a relation and prevent attributes not in the fillable.
                 */
                else if (array_search($key, $model->getFillable(), true) !== false)
                {
                    $model->$key = $value;   
                }
            }
            /**
             * Save the model.
             */
            $model->save();
            
            /**
             * Loop through the relations array.
             */
            foreach ($relations as $key => $value) 
            {
                /**
                 * If the relation is marked for delete then delete it.
                 */
                if ($value == 'delete' && $model->$key()->count())
                {
                    $model->$key()->delete();
                }
                /**
                 * If the relation is an array.
                 */
                else if (gettype($value) == 'array') 
                {
                    $ids = [];
                    /**
                     * Loop through the relations.
                     */
                    foreach ($value as $val) 
                    {
                        switch (class_basename($model->$key())) 
                        {
                            /**
                             * If the relation is one to many then update it's foreign key with
                             * the model id and save it then add its id to ids array to delete all 
                             * relations who's id isn't in the ids array.
                             */
                            case 'HasMany':
                                $foreignKeyName       = explode('.', $model->$key()->getForeignKey())[1];
                                $val->$foreignKeyName = $model->id;
                                $val->save();
                                $ids[] = $val->id;
                                break;

                            /**
                             * If the relation is many to many then add it's id to the ids array to
                             * attache these ids to the model.
                             */
                            case 'BelongsToMany':
                                $val->save();
                                $ids[] = $val->id;
                                break;
                        }
                    }
                    switch (class_basename($model->$key())) 
                    {
                        /**
                         * If the relation is one to many then delete all 
                         * relations who's id isn't in the ids array.
                         */
                        case 'HasMany':
                            $model->$key()->whereNotIn('id', $ids)->delete();
                            break;

                        /**
                         * If the relation is many to many then 
                         * detach the previous data and attach 
                         * the ids array to the model.
                         */
                        case 'BelongsToMany':
                            $model->$key()->detach();
                            $model->$key()->attach($ids);
                            break;
                    }
                }
                /**
                 * If the relation isn't array.
                 */
                else
                {
                    switch (class_basename($model->$key())) 
                    {
                        /**
                         * If the relation is one to many or one to one.
                         */
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
    
        /**
         * return the saved mdel with the given relations.
         */
        return $this->find($model->id, $with);
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
        if ($attribute == 'id') 
        {
            \DB::transaction(function () use ($value, $attribute, &$result, $saveLog) {
                $model = $this->model->lockForUpdate()->find($value);
                if ( ! $model) 
                {
                    \ErrorHandler::notFound(class_basename($this->model) . ' with id : ' . $value);
                }
                
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
     * @param  array   $columns
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
     * Abstract method that return the necessary 
     * information (full model namespace)
     * needed to preform the previous actions.
     * 
     * @return string
     */
    abstract protected function getModel();
}