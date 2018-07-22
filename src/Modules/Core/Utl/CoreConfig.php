<?php namespace App\Modules\Core\Utl;

class CoreConfig
{
    public function getConfig()
    {
        return [
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
				'oauthClients' => [
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
				'notifications' => [
					'list'   => [],
					'unread' => [],
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
				'oauthClients' => [
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
						'update'           => ['oauthClients', 'users', 'groups'],
						'save'             => ['oauthClients', 'users', 'groups'],
						'delete'           => ['oauthClients', 'users', 'groups'],
						'restore'          => ['oauthClients', 'users', 'groups'],
						'revoke'           => ['oauthClients', 'users', 'groups'],
						'ubRevoke'         => ['oauthClients', 'users', 'groups'],
						'regenerateSecret' => ['oauthClients', 'users', 'groups'],
					],
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
						'update'   => ['users', 'groups', 'permissions'],
						'save'     => ['settings'],
						'delete'   => ['settings'],
						'restore'  => ['settings'],
						'saveMany' => ['settings'],
					]
				]
			]
		];
    }
}