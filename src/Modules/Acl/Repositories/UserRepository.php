<?php namespace App\Modules\Acl\Repositories;

use App\Modules\Core\AbstractRepositories\AbstractRepository;

class UserRepository extends AbstractRepository
{
	/**
	 * Return the model full namespace.
	 * 
	 * @return string
	 */
	protected function getModel()
	{
		return 'App\Modules\Acl\AclUser';
	}

	/**
	 * Check if the logged in user or the given user 
	 * has the given permissions on the given model.
	 * 
	 * @param  string  $nameOfPermission
	 * @param  string  $model            
	 * @param  boolean $user
	 * @return boolean
	 */
	public function can($nameOfPermission, $model, $user = false )
	{		
		$user        = $user ?: \Auth::user();
		$permissions = [];
		\Core::users()->find($user->id, ['groups.permissions'])->groups->lists('permissions')->each(function ($permission) use (&$permissions, $model){
			$permissions = array_merge($permissions, $permission->where('model', $model)->lists('name')->toArray()); 
		});
		
		return in_array($nameOfPermission, $permissions);
	}

	/**
	 * Check if the logged in user has the given group.
	 * 
	 * @param  string  $groupName
	 * @return boolean
	 */
	public function hasGroup($groupName)
	{
		$groups = \Core::users()->find(\Auth::user()->id)->groups;
		return $groups->lists('name')->search($groupName, true);
	}

	/**
	 * Assign the given group ids to the given user.
	 * 
	 * @param  integer $user_id    
	 * @param  array   $group_ids
	 * @return object
	 */
	public function assignGroups($user_id, $group_ids)
	{
		\DB::transaction(function () use ($user_id, $group_ids) {
			$user = \Core::users()->find($user_id);
			$user->groups()->detach();
			$user->groups()->attach($group_ids);
		});

        return \Core::users()->find($user_id);
	}
}
