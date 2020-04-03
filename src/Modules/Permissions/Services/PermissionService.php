<?php

namespace App\Modules\Permissions\Services;

use App\Modules\Core\BaseClasses\BaseService;
use App\Modules\Permissions\Repositories\PermissionRepository;

class PermissionService extends BaseService
{
    /**
     * Init new object.
     *
     * @param   PermissionRepository $repo
     * @return  void
     */
    public function __construct(PermissionRepository $repo)
    {
        parent::__construct($repo);
    }
}
