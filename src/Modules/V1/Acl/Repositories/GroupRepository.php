<?php namespace App\Modules\V1\Acl\Repositories;

use App\Modules\V1\Core\AbstractRepositories\AbstractRepository;

class GroupRepository extends AbstractRepository
{
	/**
	 * Return the model full namespace.
	 * 
	 * @return string
	 */
	protected function getModel()
	{
		return 'App\Modules\V1\Acl\AclGroup';
	}

	/**
	 * Assign the given permission ids to the given group.
	 * 
	 * @param  integer $groupId    
	 * @param  array   $permissionIds
	 * @return object
	 */
	public function assignPermissions($groupId, $permissionIds)
	{
		\DB::transaction(function () use ($groupId, $permissionIds) {
			$group = $this->find($groupId);
			$group->permissions()->detach();
			$group->permissions()->attach($permissionIds);
		});

        return $this->find($group_id);
	}

	/**
     *  Return the users in the given group in pages.
     * 
     * @param  integer $groupId
     * @param  integer $perPage
     * @param  array   $relations
     * @param  string  $sortBy
     * @param  boolean $desc
     * @return collection
     */
    public function users($groupId, $perPage = 15, $relations = [], $sortBy = 'created_at', $desc = 1)
    {
		$group = $this->find($groupId);
		$sort  = $desc ? 'desc' : 'asc';

        return $group->users()->with($relations)->orderBy($sortBy, $sort)->paginate($perPage);
    }
}
