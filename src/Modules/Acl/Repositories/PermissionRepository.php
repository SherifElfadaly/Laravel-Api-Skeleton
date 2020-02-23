<?php namespace App\Modules\Acl\Repositories;

use App\Modules\Core\BaseClasses\BaseRepository;
use App\Modules\Acl\AclPermission;

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
