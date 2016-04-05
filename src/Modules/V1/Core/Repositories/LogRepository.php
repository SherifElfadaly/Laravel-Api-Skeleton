<?php namespace App\Modules\V1\Core\Repositories;

use App\Modules\V1\Core\AbstractRepositories\AbstractRepository;

class LogRepository extends AbstractRepository
{
	/**
	 * Return the model full namespace.
	 * 
	 * @return string
	 */
	protected function getModel()
	{
		return 'App\Modules\V1\Core\Log';
	}
}
