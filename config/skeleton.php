<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Disable Confirm Email
    |--------------------------------------------------------------------------
    |
    | Used to determine whether to enable email confirmation or not.
    |
    */

    'disable_confirm_email' => env('DISABLE_CONFIRM_EMAIL', false),

    /*
    |--------------------------------------------------------------------------
    | Confirm Email URL
    |--------------------------------------------------------------------------
    |
    | URL that is sent to the user to confirm his newly created account.
    |
    */
   
    'confrim_email_url' => env('CONFIRM_EMAIL_URL'),

    /*
    |--------------------------------------------------------------------------
    | Reset Password URL
    |--------------------------------------------------------------------------
    |
    | URL that is sent to the user to reset his password.
    |
    */
   
    'reset_password_url' => env('RESET_PASSWORD_URL'),

    /*
    |--------------------------------------------------------------------------
    | Passport Client Id
    |--------------------------------------------------------------------------
    |
    | Laravel generated client id from passort:install command.
    |
    */
   
    'passport_client_id' => env('PASSWORD_CLIENT_ID'),

    /*
    |--------------------------------------------------------------------------
    | Passport Client Secret
    |--------------------------------------------------------------------------
    |
    | Laravel generated client secret from passort:install command.
    |
    */
   
    'passport_client_secret' => env('PASSWORD_CLIENT_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Social Pass
    |--------------------------------------------------------------------------
    |
    | Password used to identify the social login.
    |
    */

    'social_pass' => env('SOCIAL_PASS', false),

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
