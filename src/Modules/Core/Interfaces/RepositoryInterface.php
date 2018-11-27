<?php namespace App\Modules\Core\Interfaces;

interface RepositoryInterface
{
	/**
	 * Fetch all records with relations from the storage.
	 * 
	 * @param  array  $relations
	 * @param  array  $sortBy
	 * @param  array  $desc
	 * @param  array  $columns
	 * @return collection
	 */
	public function all($relations = [], $sortBy = 'created_at', $desc = 0, $columns = array('*'));
    
	/**
	 * Fetch all records with relations from storage in pages 
	 * that matche the given query.
	 * 
	 * @param  string  $query
	 * @param  integer $perPage
	 * @param  array   $relations
	 * @param  array   $sortBy
	 * @param  array   $desc
	 * @param  array   $columns
	 * @return collection
	 */
	public function search($query, $perPage = 15, $relations = [], $sortBy = 'created_at', $desc = 0, $columns = array('*'));

	/**
	 * Fetch all records with relations from storage in pages.
	 * 
	 * @param  integer $perPage
	 * @param  array   $relations
	 * @param  array   $sortBy
	 * @param  array   $desc
	 * @param  array   $columns
	 * @return collection
	 */
	public function paginate($perPage = 15, $relations = [], $sortBy = 'created_at', $desc = 0, $columns = array('*'));
    
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
	public function paginateBy($conditions, $perPage = 15, $relations = [], $sortBy = 'created_at', $desc = 0, $columns = array('*'));

	 /**
	  * Save the given model/models to the storage.
	  * 
	  * @param  array $data
	  * @return mixed
	  */
	public function save(array $data);

	/**
	 * Update record in the storage based on the given
	 * condition.
	 * 
	 * @param  var     $value condition value
	 * @param  array   $data
	 * @param  string  $attribute condition column name
	 * @return integer affected rows
	 */
	public function update($value, array $data, $attribute = 'id');

	/**
	 * Delete record from the storage based on the given
	 * condition.
	 * 
	 * @param  var     $value condition value
	 * @param  string  $attribute condition column name
	 * @return integer affected rows
	 */
	public function delete($value, $attribute = 'id');
    
	/**
	 * Fetch records from the storage based on the given
	 * id.
	 * 
	 * @param  integer $id
	 * @param  array   $relations
	 * @param  array   $columns
	 * @return object
	 */
	public function find($id, $relations = [], $columns = array('*'));
    
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
	public function findBy($conditions, $relations = [], $sortBy = 'created_at', $desc = 0, $columns = array('*'));

	/**
	 * Fetch the first record fro the storage based on the given
	 * condition.
	 * 
	 * @param  array   $conditions array of conditions
	 * @param  array   $relations
	 * @param  array   $columns
	 * @return object
	 */
	public function first($conditions, $relations = [], $columns = array('*'));
}