<?php

namespace App\Modules\Users\Repositories;

use App\Modules\Core\BaseClasses\Contracts\BaseRepositoryInterface;

interface UserRepositoryInterface extends BaseRepositoryInterface
{

    /**
     * Detach all roles from the given user.
     *
     * @param  mixed $user
     * @return bool
     */
    public function detachRoles(mixed $user): bool;

    /**
     * Attach role ids to the given user.
     *
     * @param  mixed $user
     * @param  array $roleIds
     * @return bool
     */
    public function attachRoles(mixed $user, array $roleIds): bool;

    /**
     * Count the given user the given roles.
     *
     * @param  mixed $user
     * @param  array $roles
     * @return int
     */
    public function countRoles(mixed $user, array $roles): int;
}
