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
            'index' => [],
            'show' => [],
            'account' => [],
        ],
        'permission' => [
            'index' => [],
            'show' => [],
        ],
        'role' => [
            'index' => [],
            'show' => [],
        ],
        'oauthClient' => [
            'index' => [],
            'show' => [],
        ],
        'notification' => [
            'index' => [],
            'unread' => [],
        ],
        'pushNotificationDevice' => [
            'index' => [],
            'show' => [],
        ],
        'report' => [
            'index' => [],
            'show' => [],
        ],
        'setting' => [
            'index' => [],
            'show' => [],
        ],
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
                'list',
                'find',
                'findBy',
                'paginate',
                'paginateBy',
                'first',
                'deleted'
            ],
            'clear' => [
                'save' => ['oauthClient'],
                'delete' => ['oauthClient'],
                'restore' => ['oauthClient'],
                'revoke' => ['oauthClient'],
                'ubRevoke' => ['oauthClient'],
                'regenerateSecret' => ['oauthClient'],
            ],
        ],
        'setting' => [
            'cache' => [
                'list',
                'find',
                'findBy',
                'paginate',
                'paginateBy',
                'first',
                'deleted'
            ],
            'clear' => [
                'save' => ['setting'],
                'saveMany' => ['setting'],
            ]
        ]
    ]
];
