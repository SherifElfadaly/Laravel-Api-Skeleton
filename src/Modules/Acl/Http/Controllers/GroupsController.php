<?php

namespace App\Modules\Acl\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Core\Http\Controllers\BaseApiController;
use \App\Modules\Acl\Repositories\GroupRepository;
use App\Modules\Core\Utl\CoreConfig;

class GroupsController extends BaseApiController
{
    /**
     * The validations rules used by the base api controller
     * to check before add.
     * @var array
     */
    protected $validationRules = [
    'name' => 'required|string|max:100|unique:groups,name,{id}'
    ];

    /**
     * Init new object.
     *
     * @param   GroupRepository $repo
     * @param   CoreConfig      $config
     * @return  void
     */
    public function __construct(GroupRepository $repo, CoreConfig $config)
    {
        parent::__construct($repo, $config, 'App\Modules\Acl\Http\Resources\AclGroup');
    }

    /**
     * Handle an assign permissions to group request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function assignpermissions(Request $request)
    {
        $this->validate($request, [
            'permission_ids' => 'required|exists:permissions,id',
            'group_id'       => 'required|array|exists:groups,id'
            ]);

        return new $this->modelResource($this->repo->assignPermissions($request->get('group_id'), $request->get('permission_ids')));
    }
}
