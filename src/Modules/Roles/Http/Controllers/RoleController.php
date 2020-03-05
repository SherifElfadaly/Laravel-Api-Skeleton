<?php

namespace App\Modules\Roles\Http\Controllers;

use App\Modules\Core\BaseClasses\BaseApiController;
use App\Modules\Roles\Repositories\RoleRepository;
use App\Modules\Roles\Http\Requests\InsertRole;
use App\Modules\Roles\Http\Requests\UpdateRole;

class RoleController extends BaseApiController
{
    /**
     * List of all route actions that the base api controller
     * will skip permissions check for them.
     * @var array
     */
    protected $skipPermissionCheck = [];

    /**
     * List of all route actions that the base api controller
     * will skip login check for them.
     * @var array
     */
    protected $skipLoginCheck = [];

    /**
     * Init new object.
     *
     * @param   RoleRepository $repo
     * @return  void
     */
    public function __construct(RoleRepository $repo)
    {
        parent::__construct($repo, 'App\Modules\Roles\Http\Resources\Role');
    }

    /**
     * Insert the given model to storage.
     *
     * @param InsertRole $request
     * @return \Illuminate\Http\Response
     */
    public function insert(InsertRole $request)
    {
        return new $this->modelResource($this->repo->save($request->all()));
    }

    /**
     * Update the given model to storage.
     *
     * @param UpdateRole $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRole $request)
    {
        return new $this->modelResource($this->repo->save($request->all()));
    }
}
