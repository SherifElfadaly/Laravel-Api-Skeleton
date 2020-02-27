<?php namespace App\Modules\Permissions\Repositories;

use App\Modules\Core\BaseClasses\BaseRepository;
use App\Modules\Permissions\AclPermission;

class PermissionRepository extends BaseRepository
{
    /**
     * Init new object.
     *
     * @param   AclPermission $model
     * @return  void
     */
    public function __construct(AclPermission $model)
    {
        parent::__construct($model);
    }
}
