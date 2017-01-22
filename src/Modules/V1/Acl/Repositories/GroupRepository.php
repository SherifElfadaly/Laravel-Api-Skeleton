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
}
