<?php

namespace App\Modules\Roles\Services;

use App\Modules\Core\BaseClasses\BaseService;
use App\Modules\Roles\Repositories\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RoleService extends BaseService implements RoleServiceInterface
{
    /**
     * Init new object.
     *
     * @param   RoleRepositoryInterface $repo
     * @return  void
     */
    public function __construct(RoleRepositoryInterface $repo)
    {
        parent::__construct($repo);
    }

    /**
     * Assign the given permission ids to the given role.
     *
     * @param  integer $roleId
     * @param  array   $permissionIds
     * @return Model
     */
    public function assignPermissions(int $roleId, array $permissionIds): Model
    {
        $role = new Model();
        DB::transaction(function () use ($roleId, $permissionIds, &$role) {
            $role = $this->repo->find($roleId);
            $this->repo->detachPermissions($role);
            $this->repo->attachPermissions($role, $permissionIds);
        });

        return $role;
    }
}
