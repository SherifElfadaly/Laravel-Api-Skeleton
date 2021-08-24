<?php

namespace App\Modules\Roles\Services;

use App\Modules\Core\BaseClasses\Contracts\BaseServiceInterface;
use Illuminate\Database\Eloquent\Model;

interface RoleServiceInterface extends BaseServiceInterface
{

    /**
     * Assign the given permission ids to the given role.
     *
     * @param  integer $roleId
     * @param  array   $permissionIds
     * @return Model
     */
    public function assignPermissions(int $roleId, array $permissionIds): Model;
}
