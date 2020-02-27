<?php

namespace App\Modules\Permissions\Http\Controllers;

use App\Modules\Core\BaseClasses\BaseApiController;
use App\Modules\Permissions\Repositories\PermissionRepository;
use App\Modules\Core\Utl\CoreConfig;

class PermissionController extends BaseApiController
{
    /**
     * Init new object.
     *
     * @param   PermissionRepository $repo
     * @param   CoreConfig           $config
     * @return  void
     */
    public function __construct(PermissionRepository $repo, CoreConfig $config)
    {
        parent::__construct($repo, $config, 'App\Modules\Permissions\Http\Resources\AclPermission');
    }
}
