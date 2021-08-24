<?php

namespace App\Modules\Roles\Repositories;

use App\Modules\Core\BaseClasses\BaseRepository;
use App\Modules\Roles\Role;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
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
     * @return bool
     */
    public function detachPermissions(mixed $role): bool
    {
        $role = ! filter_var($role, FILTER_VALIDATE_INT) ? $role : $this->find($role);
        $role->permissions()->detach();

        return true;
    }

    /**
     * Attach permission ids to the given role.
     *
     * @param  mixed $role
     * @param  array $permissionIds
     * @return bool
     */
    public function attachPermissions(mixed $role, array $permissionIds): bool
    {
        $role = ! filter_var($role, FILTER_VALIDATE_INT) ? $role : $this->find($role);
        $role->permissions()->attach($permissionIds);

        return true;
    }
}
