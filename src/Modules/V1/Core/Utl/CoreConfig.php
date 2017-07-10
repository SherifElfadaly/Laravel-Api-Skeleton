<?php namespace App\Modules\V1\Core\Utl;
use \App\Modules\V1\Core\Settings;

class CoreConfig
{
    public function getConfig()
    {
        return [
        	'resetLink' => '{{link_here}}',
			/**
			 * Specify what relations should be used for every model.
			 */
			'relations' => [
				'users' => [
					'list'       => [],
					'find'       => [],
					'findby'     => [],
					'paginate'   => [],
					'paginateby' => [],
					'first'      => [],
					'search'     => [],
					'account'    => [],
					'group'      => [],
					'deleted'    => [],
				],
				'permissions' => [
					'list'       => [],
					'find'       => [],
					'findby'     => [],
					'paginate'   => [],
					'paginateby' => [],
					'first'      => [],
					'search'     => [],
					'deleted'    => [],
				],
				'groups' => [
					'list'       => [],
					'find'       => [],
					'findby'     => [],
					'paginate'   => [],
					'paginateby' => [],
					'first'      => [],
					'search'     => [],
					'deleted'    => [],
				],
				'logs' => [
					'list'       => [],
					'find'       => [],
					'findby'     => [],
					'paginate'   => [],
					'paginateby' => [],
					'first'      => [],
					'search'     => [],
					'deleted'    => [],
				],
				'notifications' => [
					'list'       => [],
					'find'       => [],
					'findby'     => [],
					'paginate'   => [],
					'paginateby' => [],
					'first'      => [],
					'search'     => [],
					'deleted'    => [],
				],
				'pushNotificationDevices' => [
					'list'       => [],
					'find'       => [],
					'findby'     => [],
					'paginate'   => [],
					'paginateby' => [],
					'first'      => [],
					'search'     => [],
					'deleted'    => [],
				],
				'reports' => [
					'list'       => [],
					'find'       => [],
					'findby'     => [],
					'paginate'   => [],
					'paginateby' => [],
					'first'      => [],
					'search'     => [],
					'deleted'    => [],
				],
				'settings' => [
					'list'       => [],
					'find'       => [],
					'findby'     => [],
					'paginate'   => [],
					'paginateby' => [],
					'first'      => [],
					'search'     => [],
					'deleted'    => [],
				],
			],
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
						'update'       => ['users', 'groups'],
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
		];
    }
}