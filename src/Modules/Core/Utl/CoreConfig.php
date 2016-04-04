<?php namespace App\Modules\Core\Utl;
use \App\Modules\Core\Settings;

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
					'find'       => [],
					'findBy'     => [],
					'paginate'   => [],
					'paginateBy' => [],
					'first'      => [],
				],
				'permissions' => [
					'all'        => ['groups'],
					'find'       => ['groups'],
					'findBy'     => ['groups'],
					'paginate'   => ['groups'],
					'paginateBy' => ['groups'],
					'first'      => ['groups'],
				],
				'groups' => [
					'all'        => ['users'],
					'find'       => ['users'],
					'findBy'     => ['users'],
					'paginate'   => ['users'],
					'paginateBy' => ['users'],
					'first'      => ['users'],
				],
				'logs' => [
					'all'        => ['user', 'item'],
					'find'       => ['user', 'item'],
					'findBy'     => ['user', 'item'],
					'paginate'   => ['user', 'item'],
					'paginateBy' => ['user', 'item'],
					'first'      => ['user', 'item'],
				],
				'notifications' => [
					'all'        => ['item'],
					'find'       => ['item'],
					'findBy'     => ['item'],
					'paginate'   => ['item'],
					'paginateBy' => ['item'],
					'first'      => ['item'],
				],
			]
		]);
    }
}