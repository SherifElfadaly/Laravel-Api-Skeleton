<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Relations Between Models
    |--------------------------------------------------------------------------
    |
    | Specify what relations should be used for every model when fetching.
    |
    */
    
    'relations' => [
        'user' => [
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
        'permission' => [
            'list'       => [],
            'find'       => [],
            'findby'     => [],
            'paginate'   => [],
            'paginateby' => [],
            'first'      => [],
            'search'     => [],
            'deleted'    => [],
        ],
        'group' => [
            'list'       => [],
            'find'       => [],
            'findby'     => [],
            'paginate'   => [],
            'paginateby' => [],
            'first'      => [],
            'search'     => [],
            'deleted'    => [],
        ],
        'oauthClient' => [
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
        'notification' => [
            'list'   => [],
            'unread' => [],
        ],
        'pushNotificationDevice' => [
            'list'       => [],
            'find'       => [],
            'findby'     => [],
            'paginate'   => [],
            'paginateby' => [],
            'first'      => [],
            'search'     => [],
            'deleted'    => [],
        ],
        'report' => [
            'list'       => [],
            'find'       => [],
            'findby'     => [],
            'paginate'   => [],
            'paginateby' => [],
            'first'      => [],
            'search'     => [],
            'deleted'    => [],
        ],
        'setting' => [
            'list'       => [],
            'find'       => [],
            'findby'     => [],
            'paginate'   => [],
            'paginateby' => [],
            'first'      => [],
            'search'     => [],
            'deleted'    => [],
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Configurations
    |--------------------------------------------------------------------------
    |
    | Specify when to cache or clear cache for each model/
    |
    */

    'cache_config' => [
        'oauthClient' => [
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
        'setting' => [
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
                'update'   => ['settings'],
                'save'     => ['settings'],
                'delete'   => ['settings'],
                'restore'  => ['settings'],
                'saveMany' => ['settings'],
            ]
        ]
    ]
];
