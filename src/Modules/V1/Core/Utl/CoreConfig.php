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
					'findby'     => [],
					'paginate'   => ['groups'],
					'paginateby' => [],
					'first'      => [],
					'search'     => [],
					'account'    => ['groups'],
					'group'      => [],
				],
				'permissions' => [
					'all'        => [],
					'find'       => ['groups'],
					'findby'     => [],
					'paginate'   => [],
					'paginateby' => [],
					'first'      => ['groups'],
					'search'     => [],
				],
				'groups' => [
					'all'        => [],
					'find'       => ['permissions'],
					'findby'     => [],
					'paginate'   => [],
					'paginateby' => [],
					'first'      => ['permissions'],
					'search'     => [],
				],
				'logs' => [
					'all'        => ['user', 'item'],
					'find'       => ['user', 'item'],
					'findby'     => ['user', 'item'],
					'paginate'   => ['user', 'item'],
					'paginateby' => ['user', 'item'],
					'first'      => ['user', 'item'],
					'search'     => ['user', 'item'],
				],
				'notifications' => [
					'all'        => ['item'],
					'find'       => ['item'],
					'findby'     => ['item'],
					'paginate'   => ['item'],
					'paginateby' => ['item'],
					'first'      => ['item'],
					'search'     => ['item'],
				],
			]
			/**
			 * Specify caching config for each api.
			 */
			'cacheConfig' => [
				'users' => [
					'cache' => [
						'all',
						'find',
						'findBy',
						'paginate',
						'paginateBy',
						'first',
						'search',
						'account',
						'group',
						'deleted'
					],
					'clear' => [
						'block'        => ['users', 'groups'],
						'unblock'      => ['users', 'groups'],
						'register'     => ['users', 'groups'],
						'assignGroups' => ['users', 'groups'],
						'saveProfile'  => ['users', 'groups'],
						'update'       => ['users', 'groups', 'permissions'],
						'save'         => ['users', 'groups'],
						'delete'       => ['users', 'groups'],
						'restore'      => ['users', 'groups'],
					],
				],
				'permissions' => [
					'cache' => [
						'all',
						'find',
						'findBy',
						'paginate',
						'paginateBy',
						'first',
						'search',
						'deleted'
					],
					'clear' => [
						'update'  => ['users', 'groups', 'permissions'],
						'save'    => ['users', 'groups', 'permissions'],
						'delete'  => ['users', 'groups', 'permissions'],
						'restore' => ['users', 'groups', 'permissions'],
					]
				],
				'groups' => [
					'cache' => [
						'all',
						'find',
						'findBy',
						'paginate',
						'paginateBy',
						'first',
						'search',
						'deleted'
					],
					'clear' => [
						'update'            => ['users', 'groups', 'permissions'],
						'save'              => ['users', 'groups', 'permissions'],
						'delete'            => ['users', 'groups', 'permissions'],
						'restore'           => ['users', 'groups', 'permissions'],
						'assignPermissions' => ['users', 'groups', 'permissions'],
					]
				],
				'settings' => [
					'cache' => [
						'all',
						'find',
						'findBy',
						'paginate',
						'paginateBy',
						'first',
						'search',
						'deleted'
					],
					'clear' => [
						'update'  => ['users', 'groups', 'permissions'],
						'save'    => ['settings'],
						'delete'  => ['settings'],
						'restore' => ['settings'],
					]
				]
			]
		]);
    }
}