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
					'find'       => ['groups'],
					'findby'     => [],
					'paginate'   => ['groups'],
					'paginateby' => [],
					'first'      => [],
					'search'     => [],
					'account'    => ['groups'],
					'group'      => [],
					'deleted'    => [],
				],
				'permissions' => [
					'list'       => [],
					'find'       => ['groups'],
					'findby'     => [],
					'paginate'   => [],
					'paginateby' => [],
					'first'      => ['groups'],
					'search'     => [],
					'deleted'    => [],
				],
				'groups' => [
					'list'       => [],
					'find'       => ['permissions'],
					'findby'     => [],
					'paginate'   => [],
					'paginateby' => [],
					'first'      => ['permissions'],
					'search'     => [],
					'deleted'    => [],
				],
				'logs' => [
					'list'       => ['user', 'item'],
					'find'       => ['user', 'item'],
					'findby'     => ['user', 'item'],
					'paginate'   => ['user', 'item'],
					'paginateby' => ['user', 'item'],
					'first'      => ['user', 'item'],
					'search'     => ['user', 'item'],
					'deleted'    => [],
				],
				'notifications' => [
					'list'       => ['item'],
					'find'       => ['item'],
					'findby'     => ['item'],
					'paginate'   => ['item'],
					'paginateby' => ['item'],
					'first'      => ['item'],
					'search'     => ['item'],
					'deleted'    => [],
				],
				'pushNotificationDevices' => [
					'list'       => ['user'],
					'find'       => ['user'],
					'findby'     => ['user'],
					'paginate'   => ['user'],
					'paginateby' => ['user'],
					'first'      => ['user'],
					'search'     => ['user'],
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
						'list',
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
						'list',
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
						'list',
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
						'list',
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