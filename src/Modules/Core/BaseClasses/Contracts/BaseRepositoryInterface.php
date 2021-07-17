<?php

namespace App\Modules\Core\BaseClasses\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface BaseRepositoryInterface
{
  /**
   * Fetch all records with relations from the storage.
   *
   * @param  array  $relations
   * @param  string $sortBy
   * @param  bool   $desc
   * @param  array  $columns
   * @return collection
   */
    public function all(array $relations = [], string $sortBy = 'created_at', bool $desc = true, array $columns = ['*']): Collection;

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
   * Count all records based on the given condition from storage.
   *
   * @param  array $conditions array of conditions
   * @return int
   */
    public function count(array $conditions = []): int;

  /**
   * Pluck column based on the given condition from storage.
   *
   * @param  array  $conditions array of conditions
   * @param  string $column
   * @return collection
   */
    public function pluck(array $conditions, string $column): Collection;

  /**
   * Save the given model to the storage.
   *
   * @param  array $data
   * @return Model
   */
    public function save(array $data): Model;

  /**
   * Insert the given model/models to the storage.
   *
   * @param  array $data
   * @return bool
   */
    public function insert(array $data): bool;

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
   * @return Model
   */
    public function find(int $id, array $relations = [], array $columns = ['*']): Model;

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
