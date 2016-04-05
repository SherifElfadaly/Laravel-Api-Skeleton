<?php namespace App\Modules\V1\Acl\Repositories;

use App\Modules\V1\Core\AbstractRepositories\AbstractRepository;

class PermissionRepository extends AbstractRepository
{
	/**
	 * Return the model full namespace.
	 * 
	 * @return string
	 */
	protected function getModel()
	{
		return 'App\Modules\V1\Acl\AclPermission';
	}
}
