<?php

namespace App\Modules\Users\Repositories;

use App\Modules\Core\BaseClasses\BaseRepository;
use Illuminate\Support\Arr;
use App\Modules\Users\AclUser;

class UserRepository extends BaseRepository
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
     * @return object
     */
    public function detachRoles($user)
    {
        $user = ! filter_var($user, FILTER_VALIDATE_INT) ? $user : $this->find($user);
        $user->roles()->detach();
    }

    /**
     * Attach role ids to the given user.
     *
     * @param  mixed $user
     * @param  array $roleIds
     * @return object
     */
    public function attachRoles($user, $roleIds)
    {
        $user = ! filter_var($user, FILTER_VALIDATE_INT) ? $user : $this->find($user);
        $user->roles()->attach($roleIds);
    }

    /**
     * Count the given user the given roles.
     *
     * @param  mixed    $user
     * @param  string[] $roles
     * @return boolean
     */
    public function countRoles($user, $roles)
    {
        $user = ! filter_var($user, FILTER_VALIDATE_INT) ? $user : $this->find($user);
        return $user->roles()->whereIn('name', $roles)->count();
    }
}
