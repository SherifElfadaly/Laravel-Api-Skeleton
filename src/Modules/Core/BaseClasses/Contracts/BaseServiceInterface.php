<?php

namespace App\Modules\Core\BaseClasses\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface BaseServiceInterface
{
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
    public function list(array $relations = [], array $conditions = [], int $perPage = 15, string $sortBy = 'created_at', bool $desc = true, bool $trashed = false): LengthAwarePaginator;

  /**
   * Fetch all records with relations from the storage.
   *
   * @param  array   $relations
   * @param  string  $sortBy
   * @param  boolean $desc
   * @param  array   $columns
   * @return collection
   */
    public function all(array $relations = [], string $sortBy = 'created_at', bool $desc = true, array $columns = ['*']): Collection;

  /**
   * Fetch all records with relations from storage in pages.
   *
   * @param  integer $perPage
   * @param  array   $relations
   * @param  array   $sortBy
   * @param  array   $desc
   * @param  array   $columns
   * @return LengthAwarePaginator
   */
    public function paginate(int $perPage = 15, array $relations = [], string $sortBy = 'created_at', bool $desc = true, array $columns = ['*']): LengthAwarePaginator;

  /**
   * Fetch all records with relations based on
   * the given condition from storage in pages.
   *
   * @param  array   $conditions array of conditions
   * @param  integer $perPage
   * @param  array   $relations
   * @param  array   $sortBy
   * @param  array   $desc
   * @param  array   $columns
   * @return collection
   */
    public function paginateBy(array $conditions, int $perPage = 15, array $relations = [], string $sortBy = 'created_at', bool $desc = true, array $columns = ['*']): LengthAwarePaginator;

  /**
   * Save the given model/models to the storage.
   *
   * @param  array   $data
   * @return Model
   */
    public function save(array $data): Model;

  /**
   * Delete record from the storage based on the given
   * condition.
   *
   * @param  string $value condition value
   * @param  string $attribute condition column name
   * @return bool
   */
    public function delete(string $value, string $attribute = 'id'): bool;

  /**
   * Fetch records from the storage based on the given
   * id.
   *
   * @param  int   $id
   * @param  array $relations
   * @param  array $columns
   * @return object
   */
    public function find(int $id, array $relations = [], array $columns = ['*']): Model;

  /**
   * Fetch records from the storage based on the given
   * condition.
   *
   * @param  array   $conditions array of conditions
   * @param  array   $relations
   * @param  array   $sortBy
   * @param  array   $desc
   * @param  array   $columns
   * @return collection
   */
    public function findBy(array $conditions, array $relations = [], string $sortBy = 'created_at', bool $desc = true, array $columns = ['*']): Collection;

  /**
   * Fetch the first record fro the storage based on the given
   * condition.
   *
   * @param  array $conditions array of conditions
   * @param  array $relations
   * @param  array $columns
   * @return Model
   */
    public function first(array $conditions, array $relations = [], array $columns = ['*']): Model;

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
    public function deleted(array $conditions, int $perPage = 15, string $sortBy = 'created_at', bool $desc = true, array $columns = ['*']): LengthAwarePaginator;

  /**
   * Restore the deleted model.
   *
   * @param  int $id
   * @return bool
   */
    public function restore(int $id): bool;
}
