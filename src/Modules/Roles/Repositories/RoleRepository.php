<?php namespace App\Modules\Roles\Repositories;

use App\Modules\Core\BaseClasses\BaseRepository;
use App\Modules\Roles\Role;

class RoleRepository extends BaseRepository
{
    /**
     * Init new object.
     *
     * @param   Role $model
     * @return  void
     */
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    /**
     * Assign the given permission ids to the given role.
     *
     * @param  integer $roleId
     * @param  array   $permissionIds
     * @return object
     */
    public function assignPermissions($roleId, $permissionIds)
    {
        \DB::transaction(function () use ($roleId, $permissionIds) {
            $role = $this->find($roleId);
            $role->permissions()->detach();
            $role->permissions()->attach($permissionIds);
        });

        return $this->find($roleId);
    }
}
