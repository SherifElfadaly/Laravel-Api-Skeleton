<?php

namespace App\Modules\Permissions\Services;

use App\Modules\Core\BaseClasses\BaseService;
use App\Modules\Permissions\Repositories\PermissionRepositoryInterface;

class PermissionService extends BaseService implements PermissionServiceInterface
{
    /**
     * Init new object.
     *
     * @param   PermissionRepositoryInterface $repo
     * @return  void
     */
    public function __construct(PermissionRepositoryInterface $repo)
    {
        parent::__construct($repo);
    }
}
