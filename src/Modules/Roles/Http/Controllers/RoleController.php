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
     * Insert the given model to storage.
     *
     * @param InsertRole $request
     * @return \Illuminate\Http\Response
     */
    public function insert(InsertRole $request)
    {
        return new $this->modelResource($this->service->save($request->all()));
    }

    /**
     * Update the given model to storage.
     *
     * @param UpdateRole $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRole $request)
    {
        return new $this->modelResource($this->service->save($request->all()));
    }

    /**
     * Handle an assign permissions to role request.
     *
     * @param  AssignPermissions $request
     * @return \Illuminate\Http\Response
     */
    public function assignPermissions(AssignPermissions $request)
    {
        return new $this->modelResource($this->service->assignPermissions($request->get('role_id'), $request->get('permission_ids')));
    }
}
