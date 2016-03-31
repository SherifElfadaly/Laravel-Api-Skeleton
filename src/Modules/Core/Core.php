<?php namespace App\Modules\Core;

use App\Modules\Core\AbstractRepositories\AbstractRepositoryContainer;

class Core extends AbstractRepositoryContainer
{	
	/**
	 * Specify module repositories name space.
	 * 
	 * @return array
	 */
	protected function getRepoNameSpace()
	{
		return [
		'App\Modules\Acl\Repositories',
		'App\Modules\Logging\Repositories',
		'App\Modules\Reporting\Repositories',
		'App\Modules\Notifications\Repositories',
		'App\Modules\Core\Repositories',
		];
	}
}
