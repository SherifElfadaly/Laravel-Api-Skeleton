<?php namespace App\Modules\Core\Repositories;

use App\Modules\Core\AbstractRepositories\AbstractRepository;

class SettingRepository extends AbstractRepository
{
	/**
	 * Return the model full namespace.
	 * 
	 * @return string
	 */
	protected function getModel()
	{
		return 'App\Modules\Core\Settings';
	}
}
