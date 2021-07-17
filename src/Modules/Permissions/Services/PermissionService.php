<?php

namespace App\Modules\Permissions\Services;

use App\Modules\Core\BaseClasses\BaseService;
use App\Modules\Permissions\Repositories\PermissionRepository;
use Illuminate\Contracts\Session\Session;

class PermissionService extends BaseService
{
    /**
     * Init new object.
     *
     * @param   PermissionRepository $repo
     * @param   Session $session
     * @return  void
     */
    public function __construct(PermissionRepository $repo, Session $session)
    {
        parent::__construct($repo, $session);
    }
}
