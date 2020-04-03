<?php

namespace App\Modules\Roles\Services;

use App\Modules\Core\BaseClasses\BaseService;
use App\Modules\Roles\Repositories\RoleRepository;

class RoleService extends BaseService
{
    /**
     * Init new object.
     *
     * @param   RoleRepository $repo
     * @return  void
     */
    public function __construct(RoleRepository $repo)
    {
        parent::__construct($repo);
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
            $this->repo->detachPermissions($roleId);
            $this->repo->attachPermissions($roleId, $permissionIds);
        });

        return $role;
    }
}
