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
    | Token Expire In
    |--------------------------------------------------------------------------
    |
    | Access Token Expire In minutes.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Social Pass
    |--------------------------------------------------------------------------
    |
    | Password used to identify the social login.
    |
    */

    'social_pass' => env('SOCIAL_PASS', false),
];
