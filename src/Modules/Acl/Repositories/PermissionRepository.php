<?php namespace App\Modules\Acl\Repositories;

use App\Modules\Core\AbstractRepositories\AbstractRepository;

class PermissionRepository extends AbstractRepository
{
    /**
     * Return the model full namespace.
     *
     * @return string
     */
    protected function getModel()
    {
        return 'App\Modules\Acl\AclPermission';
    }
}
