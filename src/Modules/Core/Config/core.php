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
        'projectType' => [
            'index' => [],
            'show' => [],
        ],
        'spaceType' => [
            'index' => [],
            'show' => [],
        ],
        'section' => [
            'index' => ['styles'],
            'show' => ['styles'],
        ],
        'style' => [
            'index' => [],
            'show' => [],
        ],
        'request' => [
            'index' => [],
            'show' => ['sections'],
        ],
        'fileManager' => [
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
        ],
        'projectType' => [
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
                'save' => ['projectType'],
                'delete' => ['projectType'],
                'restore' => ['projectType']
            ],
        ],
        'spaceType' => [
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
                'save' => ['spaceType', 'section'],
                'delete' => ['spaceType', 'section'],
                'restore' => ['spaceType', 'section']
            ],
        ],
        'section' => [
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
                'save' => ['section', 'spaceType', 'style'],
                'delete' => ['section', 'spaceType', 'style'],
                'restore' => ['section', 'spaceType', 'style']
            ],
        ],
        'style' => [
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
                'save' => ['style', 'section'],
                'delete' => ['style', 'section'],
                'restore' => ['style', 'section']
            ],
        ],
    ]
];
