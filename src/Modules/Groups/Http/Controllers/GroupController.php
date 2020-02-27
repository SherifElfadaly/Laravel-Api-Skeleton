<?php

namespace App\Modules\Groups\Http\Controllers;

use App\Modules\Core\BaseClasses\BaseApiController;
use App\Modules\Groups\Repositories\GroupRepository;
use App\Modules\Core\Utl\CoreConfig;
use App\Modules\Groups\Http\Requests\AssignPermissions;
use App\Modules\Groups\Http\Requests\InsertGroup;
use App\Modules\Groups\Http\Requests\UpdateGroup;

class GroupController extends BaseApiController
{
    /**
     * Init new object.
     *
     * @param   GroupRepository $repo
     * @param   CoreConfig      $config
     * @return  void
     */
    public function __construct(GroupRepository $repo, CoreConfig $config)
    {
        parent::__construct($repo, $config, 'App\Modules\Groups\Http\Resources\AclGroup');
    }

    /**
     * Insert the given model to storage.
     *
     * @param InsertGroup $request
     * @return \Illuminate\Http\Response
     */
    public function insert(InsertGroup $request)
    {
        return new $this->modelResource($this->repo->save($request->all()));
    }

    /**
     * Update the given model to storage.
     *
     * @param UpdateGroup $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGroup $request)
    {
        return new $this->modelResource($this->repo->save($request->all()));
    }

    /**
     * Handle an assign permissions to group request.
     *
     * @param  AssignPermissions $request
     * @return \Illuminate\Http\Response
     */
    public function assignPermissions(AssignPermissions $request)
    {
        return new $this->modelResource($this->repo->assignPermissions($request->get('group_id'), $request->get('permission_ids')));
    }
}
