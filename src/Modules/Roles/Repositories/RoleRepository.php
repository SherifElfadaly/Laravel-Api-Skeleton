<?php

namespace App\Modules\Roles\Repositories;

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
     * Detach all permissions from the given role.
     *
     * @param  mixed $role
     * @return object
     */
    public function detachPermissions($role)
    {
        $role = ! is_int($role) ? $role : $this->find($role);
        $role->permissions()->detach();
    }

    /**
     * Attach permission ids to the given role.
     *
     * @param  mixed $role
     * @param  array $permissionIds
     * @return object
     */
    public function attachPermissions($role, $permissionIds)
    {
        $role = ! is_int($role) ? $role : $this->find($role);
        $role->permissions()->attach($permissionIds);
    }
}
