<?php namespace App\Modules\Acl\Repositories\V1;

use App\Modules\Core\AbstractRepositories\AbstractRepository;

class GroupRepository extends AbstractRepository
{
	/**
	 * Return the model full namespace.
	 * 
	 * @return string
	 */
	protected function getModel()
	{
		return 'App\Modules\Acl\AclGroup';
	}

	/**
	 * Assign the given permission ids to the given group.
	 * 
	 * @param  integer $group_id    
	 * @param  array   $permission_ids
	 * @return object
	 */
	public function assignPermissions($group_id, $permission_ids)
	{
		\DB::transaction(function () use ($group_id, $permission_ids) {
			$group = \Core::groups()->find($group_id);
			$group->permissions()->detach();
			$group->permissions()->attach($permission_ids);
		});

        return \Core::groups()->find($group_id);
	}
}
