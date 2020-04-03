<?php

namespace App\Modules\Permissions\Repositories;

use App\Modules\Core\BaseClasses\BaseRepository;
use App\Modules\Permissions\Permission;

class PermissionRepository extends BaseRepository
{
    /**
     * Init new object.
     *
     * @param   Permission $model
     * @return  void
     */
    public function __construct(Permission $model)
    {
        parent::__construct($model);
    }
}
