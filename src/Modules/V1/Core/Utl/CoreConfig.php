<?php namespace App\Modules\V1\Core\Utl;
use \App\Modules\V1\Core\Settings;

class CoreConfig
{
    public function getConfig()
    {
    	$customSettings = [];
    	Settings::get(['key', 'value'])->each(function ($setting) use (&$customSettings){
    		$customSettings[$setting['key']] = $setting['value'];
    	});

        return array_merge($customSettings, [
			/**
			 * Specify what relations should be used for every model.
			 */
			'relations' => [
				'users' => [
					'all'        => [],
					'find'       => ['groups'],
					'findBy'     => [],
					'paginate'   => ['groups'],
					'paginateBy' => [],
					'first'      => [],
					'search'     => [],
					'account'    => ['groups'],
				],
				'permissions' => [
					'all'        => [],
					'find'       => ['groups'],
					'findBy'     => [],
					'paginate'   => [],
					'paginateBy' => [],
					'first'      => ['groups'],
					'search'     => [],
				],
				'groups' => [
					'all'        => [],
					'find'       => ['permissions'],
					'findBy'     => [],
					'paginate'   => [],
					'paginateBy' => [],
					'first'      => ['permissions'],
					'search'     => [],
					'users' 	 => [],
				],
				'logs' => [
					'all'        => ['user', 'item'],
					'find'       => ['user', 'item'],
					'findBy'     => ['user', 'item'],
					'paginate'   => ['user', 'item'],
					'paginateBy' => ['user', 'item'],
					'first'      => ['user', 'item'],
					'search'     => ['user', 'item'],
				],
				'notifications' => [
					'all'        => ['item'],
					'find'       => ['item'],
					'findBy'     => ['item'],
					'paginate'   => ['item'],
					'paginateBy' => ['item'],
					'first'      => ['item'],
					'search'     => ['item'],
				],
			]
		]);
    }
}