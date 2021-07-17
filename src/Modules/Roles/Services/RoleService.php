<?php

namespace App\Modules\Roles\Services;

use App\Modules\Core\BaseClasses\BaseService;
use App\Modules\Roles\Repositories\RoleRepository;
use Illuminate\Contracts\Session\Session;

class RoleService extends BaseService
{
    /**
     * Init new object.
     *
     * @param   RoleRepository $repo
     * @param   Session $session
     * @return  void
     */
    public function __construct(RoleRepository $repo, Session $session)
    {
        parent::__construct($repo, $session);
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
        $role = false;
        \DB::transaction(function () use ($roleId, $permissionIds, &$role) {
            $role = $this->repo->find($roleId);
            $this->repo->detachPermissions($role);
            $this->repo->attachPermissions($role, $permissionIds);
        });

        return $role;
    }
}
