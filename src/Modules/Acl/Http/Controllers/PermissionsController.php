<?php

namespace App\Modules\Acl\Http\Controllers;

use App\Modules\Core\Http\Controllers\BaseApiController;
use App\Modules\Acl\Repositories\PermissionRepository;
use App\Modules\Core\Utl\CoreConfig;

class PermissionsController extends BaseApiController
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
        parent::__construct($repo, $config, 'App\Modules\Acl\Http\Resources\AclPermission');
    }
}
