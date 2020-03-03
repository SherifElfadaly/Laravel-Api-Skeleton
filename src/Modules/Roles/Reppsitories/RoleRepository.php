<?php namespace App\Modules\Roles\Repositories;

use App\Modules\Core\BaseClasses\BaseRepository;
use App\Modules\Roles\Role;

class RoleRepository extends BaseRepository
{
    /**
     * Init new object.
     *
     * @param   Role $model
     * @return  void
     */
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }
}
