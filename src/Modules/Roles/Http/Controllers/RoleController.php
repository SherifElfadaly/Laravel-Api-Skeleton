<?php

namespace App\Modules\Roles\Http\Controllers;

use App\Modules\Core\BaseClasses\BaseApiController;
use App\Modules\Roles\Services\RoleService;
use App\Modules\Roles\Http\Requests\AssignPermissions;
use App\Modules\Roles\Http\Requests\InsertRole;
use App\Modules\Roles\Http\Requests\UpdateRole;

class RoleController extends BaseApiController
{
    /**
     * Path of the sotre form request.
     *
     * @var string
     */
    protected $storeFormRequest = 'App\Modules\Roles\Http\Requests\StoreRole';

    /**
     * Path of the model resource
     *
     * @var string
     */
    protected $modelResource = 'App\Modules\Roles\Http\Resources\Role';

    /**
     * Init new object.
     *
     * @param   RoleService $service
     * @return  void
     */
    public function __construct(RoleService $service)
    {
        parent::__construct($service);
    }

    /**
     * Handle an assign permissions to role request.
     *
     * @param  AssignPermissions $request
     * @param  integer           $id
     * @return \Illuminate\Http\Response
     */
    public function assignPermissions(AssignPermissions $request, $id)
    {
        return new $this->modelResource($this->service->assignPermissions($id, $request->get('permission_ids')));
    }
}
