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
     * Detach all roles from the given role.
     *
     * @param  mixed $role
     * @return object
     */
    public function detachRoles($role)
    {
        $role = ! is_int($role) ? $role : $this->find($role);
        $role->roles()->detach();
    }

    /**
     * Attach role ids to the given role.
     *
     * @param  mixed $role
     * @param  array $roleIds
     * @return object
     */
    public function attachRoles($role, $roleIds)
    {
        $role = ! is_int($role) ? $role : $this->find($role);
        $role->roles()->attach($roleIds);
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
        $user = ! is_int($user) ? $user : $this->find($user);
        return $user->roles()->whereIn('name', $roles)->count();
    }
}
