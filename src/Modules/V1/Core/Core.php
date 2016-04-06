<?php namespace App\Modules\V1\Core;

use App\Modules\V1\Core\AbstractRepositories\AbstractRepositoryContainer;

class Core extends AbstractRepositoryContainer{
	/**
	 * Specify module repositories name space.
	 * 
	 * @return array
	 */
	protected function getRepoNameSpace()
	{
		return [
		'App\Modules\V1\Acl\Repositories',
		'App\Modules\V1\Logging\Repositories',
		'App\Modules\V1\Reporting\Repositories',
		'App\Modules\V1\Notifications\Repositories',
		'App\Modules\V1\Core\Repositories',
		];
	}
}
