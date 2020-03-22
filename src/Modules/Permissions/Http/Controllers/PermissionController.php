<?php

namespace App\Modules\Permissions\Http\Controllers;

use App\Modules\Core\BaseClasses\BaseApiController;
use App\Modules\Permissions\Repositories\PermissionRepository;

class PermissionController extends BaseApiController
{
    /**
     * Init new object.
     *
     * @param   PermissionRepository $repo
     * @return  void
     */
    public function __construct(PermissionRepository $repo)
    {
        parent::__construct($repo, 'App\Modules\Permissions\Http\Resources\Permission');
    }
}
