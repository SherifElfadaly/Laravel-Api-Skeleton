<?php

namespace App\Modules\Core\BaseClasses;

use App\Modules\Core\Interfaces\BaseRepositoryInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var object
     */
    public $model;
    
    /**
     * Init new object.
     *
     * @var mixed model
     * @return  void
     */
    public function __construct($model)
    {
        $this->model  = $model;
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
    public function all($relations = [], $sortBy = 'created_at', $desc = 1, $columns = ['*'])
    {
        $sort = $desc ? 'desc' : 'asc';
        return $this->model->with($relations)->orderBy($sortBy, $sort)->get($columns);
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
    public function paginate($perPage = 15, $relations = [], $sortBy = 'created_at', $desc = 1, $columns = ['*'])
    {
        $sort = $desc ? 'desc' : 'asc';
        return $this->model->with($relations)->orderBy($sortBy, $sort)->paginate($perPage, $columns);
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
    public function paginateBy($conditions, $perPage = 15, $relations = [], $sortBy = 'created_at', $desc = 1, $columns = ['*'])
    {
        $conditions = $this->constructConditions($conditions, $this->model);
        $sort       = $desc ? 'desc' : 'asc';
        return $this->model->with($relations)->whereRaw($conditions['conditionString'], $conditions['conditionValues'])->orderBy($sortBy, $sort)->paginate($perPage, $columns);
    }
    
    /**
     * Save the given model to the storage.
     *
     * @param  array $data
     * @return mixed
     */
    public function save(array $data)
    {
        \Session::put('locale', 'all');
        $model      = false;
        $relations  = [];

        \DB::transaction(function () use (&$model, $relations, $data) {
            
            $model     = $this->prepareModel($data);
            $relations = $this->prepareRelations($data, $model);
            $model     = $this->saveModel($model, $relations);
        });
            
        return $model;
    }

    /**
     * Delete record from the storage based on the given
     * condition.
     *
     * @param  var $value condition value
     * @param  string $attribute condition column name
     * @return void
     */
    public function delete($value, $attribute = 'id')
    {
        \DB::transaction(function () use ($value, $attribute) {
            $this->model->where($attribute, '=', $value)->lockForUpdate()->get()->each(function ($model) {
                $model->delete();
            });
        });
    }
    
    /**
     * Fetch records from the storage based on the given
     * id.
     *
     * @param  integer $id
     * @param  string[]   $relations
     * @param  array   $columns
     * @return object
     */
    public function find($id, $relations = [], $columns = ['*'])
    {
        return $this->model->with($relations)->find($id, $columns);
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
    public function findBy($conditions, $relations = [], $sortBy = 'created_at', $desc = 1, $columns = ['*'])
    {
        $conditions = $this->constructConditions($conditions, $this->model);
        $sort       = $desc ? 'desc' : 'asc';
        return $this->model->with($relations)->whereRaw($conditions['conditionString'], $conditions['conditionValues'])->orderBy($sortBy, $sort)->get($columns);
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
    public function first($conditions, $relations = [], $columns = ['*'])
    {
        $conditions = $this->constructConditions($conditions, $this->model);
        return $this->model->with($relations)->whereRaw($conditions['conditionString'], $conditions['conditionValues'])->first($columns);
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
    public function deleted($conditions, $perPage = 15, $sortBy = 'created_at', $desc = 1, $columns = ['*'])
    {
        unset($conditions['page']);
        unset($conditions['perPage']);
        unset($conditions['sortBy']);
        unset($conditions['sort']);
        $conditions = $this->constructConditions($conditions, $this->model);
        $sort       = $desc ? 'desc' : 'asc';
        $model      = $this->model->onlyTrashed();

        if (count($conditions['conditionValues'])) {
            $model->whereRaw($conditions['conditionString'], $conditions['conditionValues']);
        }

        return $model->orderBy($sortBy, $sort)->paginate($perPage, $columns);
    }

    /**
     * Restore the deleted model.
     *
     * @param  integer $id
     * @return void
     */
    public function restore($id)
    {
        $model = $this->model->onlyTrashed()->find($id);

        if (! $model) {
            \Errors::notFound(class_basename($this->model).' with id : '.$id);
        }

        $model->restore();
    }

    /**
     * Fill the model with the given data.
     *
     * @param   array  $data
     *
     * @return  object
     */
    public function prepareModel($data)
    {
        $modelClass = $this->model;

        /**
         * If the id is present in the data then select the model for updating,
         * else create new model.
         * @var array
         */
        $model = Arr::has($data, 'id') ? $modelClass->lockForUpdate()->find($data['id']) : new $modelClass;
        if (! $model) {
            \Errors::notFound(class_basename($modelClass).' with id : '.$data['id']);
        }

        /**
         * Construct the model object with the given data,
         * and if there is a relation add it to relations array,
         * then save the model.
         */
        foreach ($data as $key => $value) {
            if (array_search($key, $model->getFillable(), true) !== false) {
                /**
                 * If the attribute isn't a relation and prevent attributes not in the fillable.
                 */
                $model->$key = $value;
            }
        }

        return $model;
    }
    
    /**
     * Prepare related models based on the given data for the given model.
     *
     * @param   array  $data
     * @param   object $model
     *
     * @return  array
     */
    public function prepareRelations($data, $model)
    {
        /**
         * Construct the model object with the given data,
         * and if there is a relation add it to relations array,
         * then save the model.
         */
        foreach ($data as $key => $value) {
            /**
             * If the attribute is a relation.
             */
            $relation = \Str::camel($key);
            if (method_exists($model, $relation) && \Core::$relation()) {
                /**
                 * Check if the relation is a collection.
                 */
                if (class_basename($model->$relation) == 'Collection') {
                    /**
                     * If the relation has no value then marke the relation data
                     * related to the model to be deleted.
                     */
                    if (! $value || ! count($value)) {
                        $relations[$relation] = 'delete';
                    }
                }
                if (is_array($value)) {
                    /**
                     * Loop through the relation data.
                     */
                    foreach ($value as $attr => $val) {
                        /**
                         * Get the relation model.
                         */
                        $relationBaseModel = \Core::$relation()->model;

                        /**
                         * Check if the relation is a collection.
                         */
                        if (class_basename($model->$relation) == 'Collection') {
                            /**
                             * If the id is present in the data then select the relation model for updating,
                             * else create new model.
                             */
                            $relationModel = Arr::has($val, 'id') ? $relationBaseModel->lockForUpdate()->find($val['id']) : new $relationBaseModel;

                            /**
                             * If model doesn't exists.
                             */
                            if (! $relationModel) {
                                \Errors::notFound(class_basename($relationBaseModel).' with id : '.$val['id']);
                            }

                            /**
                             * Loop through the relation attributes.
                             */
                            foreach ($val as $attr => $val) {
                                /**
                                 * Prevent the sub relations or attributes not in the fillable.
                                 */
                                if (gettype($val) !== 'object' && gettype($val) !== 'array' && array_search($attr, $relationModel->getFillable(), true) !== false) {
                                    $relationModel->$attr = $val;
                                }
                            }

                            $relations[$relation][] = $relationModel;
                        } else {
                            /**
                             * Prevent the sub relations.
                             */
                            if (gettype($val) !== 'object' && gettype($val) !== 'array') {
                                /**
                                 * If the id is present in the data then select the relation model for updating,
                                 * else create new model.
                                 */
                                $relationModel = Arr::has($value, 'id') ? $relationBaseModel->lockForUpdate()->find($value['id']) : new $relationBaseModel;

                                /**
                                 * If model doesn't exists.
                                 */
                                if (! $relationModel) {
                                    \Errors::notFound(class_basename($relationBaseModel).' with id : '.$value['id']);
                                }

                                foreach ($value as $relationAttribute => $relationValue) {
                                    /**
                                     * Prevent attributes not in the fillable.
                                     */
                                    if (array_search($relationAttribute, $relationModel->getFillable(), true) !== false) {
                                        $relationModel->$relationAttribute = $relationValue;
                                    }
                                }

                                $relations[$relation] = $relationModel;
                            }
                        }
                    }
                }
            }
        }

        return $relations;
    }

    /**
     * Save the model with related models.
     *
     * @param   object  $model
     * @param   array   $relations
     *
     * @return  object
     */
    public function saveModel($model, $relations)
    {

        /**
         * Loop through the relations array.
         */
        foreach ($relations as $key => $value) {
            /**
             * If the relation is marked for delete then delete it.
             */
            if ($value == 'delete' && $model->$key()->count()) {
                $model->$key()->delete();
            } elseif (gettype($value) == 'array') {
                /**
                 * Save the model.
                 */
                $model->save();
                $ids = [];

                /**
                 * Loop through the relations.
                 */
                foreach ($value as $val) {
                    switch (class_basename($model->$key())) {
                        /**
                         * If the relation is one to many then update it's foreign key with
                         * the model id and save it then add its id to ids array to delete all
                         * relations who's id isn't in the ids array.
                         */
                        case 'HasMany':
                            $foreignKeyName       = $model->$key()->getForeignKeyName();
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
                switch (class_basename($model->$key())) {
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
            } else {
                switch (class_basename($model->$key())) {
                    /**
                     * If the relation is one to one.
                     */
                    case 'HasOne':
                        /**
                         * Save the model.
                         */
                        $model->save();
                        $foreignKeyName         = $model->$key()->getForeignKeyName();
                        $value->$foreignKeyName = $model->id;
                        $value->save();
                        break;
                    case 'BelongsTo':
                        /**
                         * Save the model.
                         */
                        $value->save();
                        $model->$key()->associate($value);
                        break;
                }
            }
        }

        /**
         * Save the model.
         */
        $model->save();

        return $model;
    }

    /**
     * Build the conditions recursively for the retrieving methods.
     * @param  array $conditions
     * @return array
     */
    protected function constructConditions($conditions, $model)
    {
        $conditionString = '';
        $conditionValues = [];
        foreach ($conditions as $key => $value) {
            if (Str::contains($key, '->')) {
                $key = $this->wrapJsonSelector($key);
            }

            if ($key == 'and') {
                $conditions       = $this->constructConditions($value, $model);
                $conditionString .= str_replace('{op}', 'and', $conditions['conditionString']).' {op} ';
                $conditionValues  = array_merge($conditionValues, $conditions['conditionValues']);
            } elseif ($key == 'or') {
                $conditions       = $this->constructConditions($value, $model);
                $conditionString .= str_replace('{op}', 'or', $conditions['conditionString']).' {op} ';
                $conditionValues  = array_merge($conditionValues, $conditions['conditionValues']);
            } else {
                if (is_array($value)) {
                    $operator = $value['op'];
                    if (strtolower($operator) == 'between') {
                        $value1 = $value['val1'];
                        $value2 = $value['val2'];
                    } else {
                        $value = Arr::get($value, 'val', '');
                    }
                } else {
                    $operator = '=';
                }
                
                if (strtolower($operator) == 'between') {
                    $conditionString  .= $key.' >= ? and ';
                    $conditionValues[] = $value1;

                    $conditionString  .= $key.' <= ? {op} ';
                    $conditionValues[] = $value2;
                } elseif (strtolower($operator) == 'in') {
                    $conditionValues  = array_merge($conditionValues, $value);
                    $inBindingsString = rtrim(str_repeat('?,', count($value)), ',');
                    $conditionString .= $key.' in ('.rtrim($inBindingsString, ',').') {op} ';
                } elseif (strtolower($operator) == 'null') {
                    $conditionString .= $key.' is null {op} ';
                } elseif (strtolower($operator) == 'not null') {
                    $conditionString .= $key.' is not null {op} ';
                } elseif (strtolower($operator) == 'has') {
                    $sql              = $model->withTrashed()->has($key)->toSql();
                    $conditions       = $this->constructConditions($value, $model->$key()->getRelated());
                    $conditionString .= rtrim(substr($sql, strpos($sql, 'exists')), ')').' and '.$conditions['conditionString'].') {op} ';
                    $conditionValues  = array_merge($conditionValues, $conditions['conditionValues']);
                } else {
                    $conditionString  .= $key.' '.$operator.' ? {op} ';
                    $conditionValues[] = $value;
                }
            }
        }
        $conditionString = '('.rtrim($conditionString, '{op} ').')';
        return ['conditionString' => $conditionString, 'conditionValues' => $conditionValues];
    }

    /**
     * Wrap the given JSON selector.
     *
     * @param  string  $value
     * @return string
     */
    protected function wrapJsonSelector($value)
    {
        $removeLast = strpos($value, ')');
        $value      = $removeLast === false ? $value : substr($value, 0, $removeLast);
        $path       = explode('->', $value);
        $field      = array_shift($path);
        $result     = sprintf('%s->\'$.%s\'', $field, collect($path)->map(function ($part) {
            return '"'.$part.'"';
        })->implode('.'));
        
        return $removeLast === false ? $result : $result.')';
    }
}
