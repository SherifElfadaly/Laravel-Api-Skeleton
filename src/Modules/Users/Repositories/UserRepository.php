<?php

namespace App\Modules\Users\Repositories;

use App\Modules\Core\BaseClasses\BaseRepository;
use App\Modules\Users\AclUser;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * Init new object.
     *
     * @param   AclUser $model
     * @return  void
     */
    public function __construct(AclUser $model)
    {
        parent::__construct($model);
    }

    /**
     * Detach all roles from the given user.
     *
     * @param  mixed $user
     * @return bool
     */
    public function detachRoles(mixed $user): bool
    {
        $user = ! filter_var($user, FILTER_VALIDATE_INT) ? $user : $this->find($user);
        $user->roles()->detach();

        return true;
    }

    /**
     * Attach role ids to the given user.
     *
     * @param  mixed $user
     * @param  array $roleIds
     * @return bool
     */
    public function attachRoles(mixed $user, array $roleIds): bool
    {
        $user = ! filter_var($user, FILTER_VALIDATE_INT) ? $user : $this->find($user);
        $user->roles()->attach($roleIds);

        return true;
    }

    /**
     * Count the given user the given roles.
     *
     * @param  mixed $user
     * @param  array $roles
     * @return int
     */
    public function countRoles(mixed $user, array $roles): int
    {
        $user = ! filter_var($user, FILTER_VALIDATE_INT) ? $user : $this->find($user);
        return $user->roles()->whereIn('name', $roles)->count();
    }
}
