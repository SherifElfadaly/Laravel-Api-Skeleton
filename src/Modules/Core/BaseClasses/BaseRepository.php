<?php

namespace App\Modules\Core\BaseClasses;

use App\Modules\Core\BaseClasses\Contracts\BaseRepositoryInterface;
use App\Modules\Core\Facades\Core;
use App\Modules\Core\Facades\Errors;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var Model
     */
    public $model;

    /**
     * Init new object.
     *
     * @param   Model$model
     * @return  void
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Fetch all records with relations from the storage.
     *
     * @param  array  $relations
     * @param  string $sortBy
     * @param  bool   $desc
     * @param  array  $columns
     * @return collection
     */
    public function all(array $relations = [], string $sortBy = 'created_at', bool $desc = true, array $columns = ['*']): Collection
    {
        $sort = $desc ? 'desc' : 'asc';
        return $this->model->with($relations)->orderBy($sortBy, $sort)->get($columns);
    }

    /**
     * Fetch all records with relations from storage in pages.
     *
     * @param  int    $perPage
     * @param  array  $relations
     * @param  string $sortBy
     * @param  bool   $desc
     * @param  array  $columns
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 15, array $relations = [], string $sortBy = 'created_at', bool $desc = true, array $columns = ['*']): LengthAwarePaginator
    {
        $sort = $desc ? 'desc' : 'asc';
        return $this->model->with($relations)->orderBy($sortBy, $sort)->paginate($perPage, $columns);
    }

    /**
     * Fetch all records with relations based on
     * the given condition from storage in pages.
     *
     * @param  array  $conditions array of conditions
     * @param  int    $perPage
     * @param  array  $relations
     * @param  string $sortBy
     * @param  bool   $desc
     * @param  array  $columns
     * @return LengthAwarePaginator
     */
    public function paginateBy(array $conditions, int $perPage = 15, array $relations = [], string $sortBy = 'created_at', bool $desc = true, array $columns = ['*']): LengthAwarePaginator
    {
        $conditions = $this->constructConditions($conditions, $this->model);
        $sort       = $desc ? 'desc' : 'asc';
        return $this->model->with($relations)->whereRaw($conditions['conditionString'], $conditions['conditionValues'])->orderBy($sortBy, $sort)->paginate($perPage, $columns);
    }

    /**
     * Count all records based on the given condition from storage.
     *
     * @param  array $conditions array of conditions
     * @return int
     */
    public function count(array $conditions = []): int
    {
        if ($conditions) {
            $conditions = $this->constructConditions($conditions, $this->model);
            return $this->model->whereRaw($conditions['conditionString'], $conditions['conditionValues'])->count();
        }

        return $this->model->count();
    }

    /**
     * Pluck column based on the given condition from storage.
     *
     * @param  array  $conditions array of conditions
     * @param  string $column
     * @return collection
     */
    public function pluck(array $conditions, string $column): Collection
    {
        $conditions = $this->constructConditions($conditions, $this->model);
        return $this->model->whereRaw($conditions['conditionString'], $conditions['conditionValues'])->pluck($column);
    }

    /**
     * Save the given model to the storage.
     *
     * @param  array $data
     * @return Model
     */
    public function save(array $data): Model
    {
        $model     = new Model();
        $relations = [];

        DB::transaction(function () use (&$model, &$relations, $data) {

            $model = $this->prepareModel($data);
            $model->save();

            $relations = $this->prepareManyToManyRelations($data, $model);
            $this->saveManyToManyRelation($model, $relations);
        });

        if (count($relations)) {
            $model->load(...array_keys($relations));
        }

        return $model;
    }

    /**
     * Insert the given model/models to the storage.
     *
     * @param  array $data
     * @return bool
     */
    public function insert(array $data): bool
    {
        return $this->model->insert($data);
    }

    /**
     * Delete record from the storage based on the given
     * condition.
     *
     * @param  string $value condition value
     * @param  string $attribute condition column name
     * @return bool
     */
    public function delete(string $value, string $attribute = 'id'): bool
    {
        DB::transaction(function () use ($value, $attribute) {
            $this->model->where($attribute, '=', $value)->lockForUpdate()->get()->each(function ($model) {
                $model->delete();
            });
        });

        return true;
    }

    /**
     * Fetch records from the storage based on the given
     * id.
     *
     * @param  int   $id
     * @param  array $relations
     * @param  array $columns
     * @return Model
     */
    public function find(int $id, array $relations = [], array $columns = ['*']): Model
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
     * @param  bool    $desc
     * @param  array   $columns
     * @return collection
     */
    public function findBy(array $conditions, array $relations = [], string $sortBy = 'created_at', bool $desc = true, array $columns = ['*']): Collection
    {
        $conditions = $this->constructConditions($conditions, $this->model);
        $sort       = $desc ? 'desc' : 'asc';
        return $this->model->with($relations)->whereRaw($conditions['conditionString'], $conditions['conditionValues'])->orderBy($sortBy, $sort)->get($columns);
    }

    /**
     * Fetch the first record from the storage based on the given
     * condition.
     *
     * @param  array $conditions array of conditions
     * @param  array $relations
     * @param  array $columns
     * @return Model
     */
    public function first(array $conditions, array $relations = [], array $columns = ['*']): Model
    {
        $conditions = $this->constructConditions($conditions, $this->model);
        return $this->model->with($relations)->whereRaw($conditions['conditionString'], $conditions['conditionValues'])->first($columns);
    }

    /**
     * Return the deleted models in pages based on the given conditions.
     *
     * @param  array  $conditions array of conditions
     * @param  int    $perPage
     * @param  string $sortBy
     * @param  bool   $desc
     * @param  array  $columns
     * @return LengthAwarePaginator
     */
    public function deleted(array $conditions, int $perPage = 15, string $sortBy = 'created_at', bool $desc = true, array $columns = ['*']): LengthAwarePaginator
    {
        unset($conditions['page'], $conditions['perPage'], $conditions['sortBy'], $conditions['sort']);
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
     * @param  int $id
     * @return bool
     */
    public function restore(int $id): bool
    {
        $model = $this->model->onlyTrashed()->find($id);

        if (!$model) {
            Errors::notFound(class_basename($this->model) . ' with id : ' . $id);
        }

        $model->restore();

        return true;
    }

    /**
     * Fill the model with the given data.
     *
     * @param   array  $data
     * @return  Model
     */
    protected function prepareModel(array $data): Model
    {
        $modelClass = $this->model;
        $model = Arr::has($data, 'id') ? $modelClass->lockForUpdate()->find($data['id']) : new $modelClass;

        if (!$model) {
            Errors::notFound(class_basename($modelClass) . ' with id : ' . $data['id']);
        }

        foreach ($data as $key => $value) {
            if (array_search($key, $model->getFillable(), true) !== false) {
                $model->$key = $value;
            }
        }

        return $model;
    }

    /**
     * Prepare many to many relation if found.
     *
     * @param   array $data
     * @param   Model $model
     *
     * @return  array
     */
    protected function prepareManyToManyRelations(array $data, Model $model): array
    {
        $relations = [];
        foreach ($data as $key => $relatedModels) {
            $relation = Str::camel($key);
            if (method_exists($model, $relation) &&
                Core::$relation() &&
                in_array(class_basename($model->$key()), ['MorphToMany', 'BelongsToMany'])
            ) {
                if (!$relatedModels || !count($relatedModels)) {
                    /**
                     * Mark the relation to be deleted.
                     */
                    $relations[$relation] = 'delete';
                }

                foreach ($relatedModels as $relatedModel) {
                    $relationBaseModel = Core::$relation()->model;
                    $relations[$relation][] = $this->prepareRelatedModel($relatedModel, $relationBaseModel);
                }
            }
        }

        return $relations;
    }

    /**
     * Prepare related models with extra values for pivot if found.
     *
     * @param   mixed  $relatedModelData
     * @param   Model  $relationBaseModel
     *
     * @return  Model
     */
    protected function prepareRelatedModel(mixed $relatedModelData, Model $relationBaseModel): Model
    {
        if (!is_array($relatedModelData)) { // if the relation is integer id
            $relatedModel = $relationBaseModel->lockForUpdate()->find($relatedModelData);
        } else {
            $relatedModel = Arr::has($relatedModelData, 'id') ? $relationBaseModel->lockForUpdate()->find($relatedModelData['id']) : new $relationBaseModel;
        }

        if (!$relatedModel) {
            Errors::notFound(class_basename($relationBaseModel) . ' with id : ' . $relatedModelData['id']);
        }

        if (is_array($relatedModelData)) {
            foreach ($relatedModelData as $attr => $val) {
                if (array_search($attr, $relatedModel->getFillable(), true) === false &&
                    gettype($val) !== 'object' &&
                    gettype($val) !== 'array' &&
                    $attr !== 'id'
                ) {
                    $extra[$attr] = $val;
                }
            }
        }

        if (isset($extra)) {
            $relatedModel->extra = $extra;
        }

        return $relatedModel;
    }

    /**
     * Save the given model many to many relations.
     *
     * @param   Model $model
     * @param   array $relations
     *
     * @return  void
     */
    protected function saveManyToManyRelation(Model $model, array $relations)
    {
        foreach ($relations as $key => $value) {
            /**
             * If the relation is marked for delete then delete it.
             */
            if ($value == 'delete' && $model->$key()->count()) {
                $model->$key()->detach();
            } else {
                $ids = [];
                foreach ($value as $val) {
                    $extra = $val->extra;
                    $ids[$val->id] = $extra ?? [];
                    unset($val->extra);
                }

                $model->$key()->detach();
                $model->$key()->attach($ids);
            }
        }
    }

    /**
     * Build the conditions recursively for the retrieving methods.
     *
     * @param  array $conditions
     * @param  Model $model
     * @return array
     */
    protected function constructConditions(array $conditions, Model $model): array
    {
        $conditionString = '';
        $conditionValues = [];
        foreach ($conditions as $key => $value) {
            if (Str::contains($key, '->')) {
                $key = $this->wrapJsonSelector($key);
            }

            if ($key == 'and') {
                $conditions       = $this->constructConditions($value, $model);
                $conditionString .= str_replace('{op}', 'and', $conditions['conditionString']) . ' {op} ';
                $conditionValues  = array_merge($conditionValues, $conditions['conditionValues']);
            } elseif ($key == 'or') {
                $conditions       = $this->constructConditions($value, $model);
                $conditionString .= str_replace('{op}', 'or', $conditions['conditionString']) . ' {op} ';
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
                    $conditionString  .= $key . ' >= ? and ';
                    $conditionValues[] = $value1;

                    $conditionString  .= $key . ' <= ? {op} ';
                    $conditionValues[] = $value2;
                } elseif (strtolower($operator) == 'in') {
                    $conditionValues  = array_merge($conditionValues, $value);
                    $inBindingsString = rtrim(str_repeat('?,', count($value)), ',');
                    $conditionString .= $key . ' in (' . rtrim($inBindingsString, ',') . ') {op} ';
                } elseif (strtolower($operator) == 'null') {
                    $conditionString .= $key . ' is null {op} ';
                } elseif (strtolower($operator) == 'not null') {
                    $conditionString .= $key . ' is not null {op} ';
                } elseif (strtolower($operator) == 'has') {
                    $sql              = $model->withTrashed()->withoutGlobalScopes()->has($key)->toSql();
                    $bindings         = $model->withTrashed()->withoutGlobalScopes()->has($key)->getBindings();
                    if ($value) {
                        $conditions       = $this->constructConditions($value, $model->$key()->getRelated());
                        $conditionString .= substr(substr($sql, strpos($sql, 'exists')), 0, -1) . ' and ' . $conditions['conditionString'] . ') {op} ';
                        $conditionValues  = array_merge($conditionValues, $bindings);
                        $conditionValues  = array_merge($conditionValues, $conditions['conditionValues']);
                    } else {
                        $conditionString .= substr(substr($sql, strpos($sql, 'exists')), 0, -1) . ') {op} ';
                        $conditionValues  = array_merge($conditionValues, $bindings);
                    }
                } else {
                    $conditionString  .= $key . ' ' . $operator . ' ? {op} ';
                    $conditionValues[] = $value;
                }
            }
        }
        $conditionString = '(' . rtrim($conditionString, '{op} ') . ')';
        return ['conditionString' => $conditionString, 'conditionValues' => $conditionValues];
    }

    /**
     * Wrap the given JSON selector.
     *
     * @param  string  $value
     * @return string
     */
    protected function wrapJsonSelector(string $value): string
    {
        $removeLast = strpos($value, ')');
        $value      = $removeLast === false ? $value : substr($value, 0, $removeLast);
        $path       = explode('->', $value);
        $field      = array_shift($path);
        $result     = sprintf('%s->\'$.%s\'', $field, collect($path)->map(function ($part) {
            return '"' . $part . '"';
        })->implode('.'));

        return $removeLast === false ? $result : $result . ')';
    }
}
