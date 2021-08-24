<?php

namespace App\Modules\Roles\Repositories;

use App\Modules\Core\BaseClasses\Contracts\BaseRepositoryInterface;

interface RoleRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Detach all permissions from the given role.
     *
     * @param  mixed $role
     * @return bool
     */
    public function detachPermissions(mixed $role): bool;

    /**
     * Attach permission ids to the given role.
     *
     * @param  mixed $role
     * @param  array $permissionIds
     * @return bool
     */
    public function attachPermissions(mixed $role, array $permissionIds): bool;
}
