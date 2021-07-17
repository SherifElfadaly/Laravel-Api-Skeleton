<?php

namespace App\Modules\Core\BaseClasses;

use App\Modules\Core\BaseClasses\Contracts\BaseRepositoryInterface;
use App\Modules\Core\BaseClasses\Contracts\BaseServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Session\Session;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseService implements BaseServiceInterface
{
    /**
     * @var BaseRepositoryInterface
     */
    public $repo;

    /**
     * @var Session
     */
    public $session;

    /**
     * Init new object.
     *
     * @param   BaseRepositoryInterface $repo
     * @param   Session $session
     * @return  void
     */
    public function __construct(BaseRepositoryInterface $repo, Session $session)
    {
        $this->repo = $repo;
        $this->session = $session;
    }

    /**
     * Fetch records with relations based on the given params.
     *
     * @param   array  $relations
     * @param   array  $conditions
     * @param   int    $perPage
     * @param   string $sortBy
     * @param   bool   $desc
     * @param   bool   $trashed
     * @return LengthAwarePaginator
     */
    public function list(array $relations = [], array $conditions = [], int $perPage = 15, string $sortBy = 'created_at', bool $desc = true, bool $trashed = false): LengthAwarePaginator
    {
        $translatable = $this->repo->model->translatable ?? [];
        $filters = $this->constructFilters($conditions);
        $sortBy = in_array($sortBy, $translatable) ? $sortBy . '->' . $this->session->get('locale') : $sortBy;

        if ($trashed) {
            return $this->deleted(['and' => $filters], $perPage ?? 15, $sortBy ?? 'created_at', $desc ?? true);
        }

        if (count($filters)) {
            return $this->paginateBy(['and' => $filters], $perPage ?? 15, $relations, $sortBy ?? 'created_at', $desc ?? true);
        }

        return $this->paginate($perPage ?? 15, $relations, $sortBy ?? 'created_at', $desc ?? true);
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
    public function all(array $relations = [], string $sortBy = 'created_at', bool $desc = true, array $columns = ['*']): Collection
    {
        return $this->repo->all($relations, $sortBy, $desc, $columns);
    }

    /**
     * Fetch all records with relations from storage in pages.
     *
     * @param  integer $perPage
     * @param  array   $relations
     * @param  string  $sortBy
     * @param  boolean $desc
     * @param  array   $columns
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 15, array $relations = [], string $sortBy = 'created_at', bool $desc = true, array $columns = ['*']): LengthAwarePaginator
    {
        return $this->repo->paginate($perPage, $relations, $sortBy, $desc, $columns);
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
     * @return LengthAwarePaginator
     */
    public function paginateBy(array $conditions, int $perPage = 15, array $relations = [], string $sortBy = 'created_at', bool $desc = true, array $columns = ['*']): LengthAwarePaginator
    {
        return $this->repo->paginateBy($conditions, $perPage, $relations, $sortBy, $desc, $columns);
    }

    /**
     * Save the given model to the storage.
     *
     * @param  array $data
     * @return Model
     */
    public function save(array $data): Model
    {
        return $this->repo->save($data);
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
        return $this->repo->delete($value, $attribute);
    }

    /**
     * Fetch records from the storage based on the given
     * id.
     *
     * @param  int   $id
     * @param  array $relations
     * @param  array $columns
     * @return object
     */
    public function find(int $id, array $relations = [], array $columns = ['*']): Model
    {
        return $this->repo->find($id, $relations, $columns);
    }

    /**
     * Fetch records from the storage based on the given
     * condition.
     *
     * @param  array  $conditions array of conditions
     * @param  array  $relations
     * @param  string $sortBy
     * @param  bool   $desc
     * @param  array  $columns
     * @return collection
     */
    public function findBy(array $conditions, array $relations = [], string $sortBy = 'created_at', bool $desc = true, array $columns = ['*']): Collection
    {
        return $this->repo->findBy($conditions, $relations, $sortBy, $desc, $columns);
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
        return $this->repo->first($conditions, $relations, $columns);
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
        return $this->repo->deleted($conditions, $perPage, $sortBy, $desc, $columns);
    }

    /**
     * Restore the deleted model.
     *
     * @param  int $id
     * @return bool
     */
    public function restore(int $id): bool
    {
        return $this->repo->restore($id);
    }

    /**
     * Prepare filters for repo.
     *
     * @param  array $conditions
     * @return array
     */
    protected function constructFilters(array $conditions): array
    {
        $filters = [];
        $translatable = $this->repo->model->translatable ?? [];
        foreach ($conditions as $key => $value) {
            if ((in_array($key, $this->repo->model->fillable ?? []) || method_exists($this->repo->model, $key) || in_array($key, ['or', 'and'])) && $key !== 'trashed') {
                /**
                 * Prepare key based on the the requested lang if it was translatable.
                 */
                $key = in_array($key, $translatable) ? $key . '->' . ($this->session->get('locale') == 'all' ? 'en' : $this->session->get('locale')) : $key;

                /**
                 * Convert 0/1 or true/false to boolean in case of not foreign key.
                 */
                if (filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) !== null && strpos($key, '_id') === false && !is_null($value)) {
                    $filters[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN);

                    /**
                     * Use in operator in case of foreign and comma seperated values.
                     */
                } elseif (!is_array($value) && strpos($key, '_id') && $value) {
                    $filters[$key] = [
                        'op' => 'in',
                        'val' => explode(',', $value)
                    ];

                    /**
                     * Use null operator in case of 0 value and foreign.
                     */
                } elseif (strpos($key, '_id') && $value == 0) {
                    $filters[$key] = [
                        'op' => 'null'
                    ];

                    /**
                     * Consider values as a sub conditions if it is array.
                     */
                } elseif (is_array($value)) {
                    $filters[$key] = $value;

                    /**
                     * Default string filteration.
                     */
                } elseif ($value) {
                    $key = 'LOWER(' . $key . ')';
                    $value = strtolower($value);
                    $filters[$key] = [
                        'op' => 'like',
                        'val' => '%' . $value . '%'
                    ];
                }
            }
        }

        return $filters;
    }
}
