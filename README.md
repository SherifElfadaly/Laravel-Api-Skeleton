# Api Skeleton

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-scrutinizer-build]][link-scrutinizer-build]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Total Downloads][ico-downloads]][link-downloads]
## Install

Via Composer

Run this command:
``` bash
composer require api-skeleton/api-skeleton
```

add the following code in Exception/Handler.php in render function

``` bash
if ($request->wantsJson())
{
    if ($exception instanceof \Illuminate\Auth\AuthenticationException) 
    {
        \ErrorHandler::unAuthorized();
    }
    if ($exception instanceof \Illuminate\Database\QueryException) 
    {
        \ErrorHandler::dbQueryError();
    }
    else if ($exception instanceof \predis\connection\connectionexception) 
    {
        \ErrorHandler::redisNotRunning();
    }
    else if ($exception instanceof \GuzzleHttp\Exception\ClientException) 
    {
        \ErrorHandler::connectionError();
    }
    else if ($exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException) 
    {
        return \Response::json($exception->getMessage(), $exception->getStatusCode());   
    }
    else if ($exception instanceof \Illuminate\Validation\ValidationException) 
    {
        return \Response::json($exception->errors(), 422);   
    }
    else if ( ! $exception instanceof \Symfony\Component\Debug\Exception\FatalErrorException)
    {
        return parent::render($request, $exception);
    }
}
else
{
    return parent::render($request, $exception);
}
```

add this in Exception/Handler.php in dontReport array

``` bash
protected $dontReport = [
\League\OAuth2\Server\Exception\OAuthServerException::class,
];
```

publish files

``` bash
php artisan vendor:publish
```

run this command
``` bash
php artisan module:optimize
```

run database migrations
``` bash
php artisan module:migrate
```

run database seeds
``` bash
php artisan module:seed
```

Install passport
``` bash
php artisan passport:install
```

Put your client id and client secret in .env
``` bash
PASSWORD_CLIENT_ID=xxxxxx
PASSWORD_CLIENT_SECRET=xxxxxx
```

In config/auth.php set the driver property of the api authentication guard to passport
``` bash
'api' => [
'driver' => 'passport',
'provider' => 'users',
]
```

In config/auth.php set user model in providers to App\Modules\Acl\AclUser::class
``` bash
'providers' => [
'users' => [
'driver' => 'eloquent',
'model' => App\Modules\Acl\AclUser::class,
]
```

In AuthServiceProvider add the following in boot method
``` bash
use Laravel\Passport\Passport;

Passport::routes(function ($router) {
    $router->forAuthorization();
    $router->forAccessTokens();
    $router->forPersonalAccessTokens();
    $router->forTransientTokens();
});
Passport::tokensExpireIn(\Carbon\Carbon::now()->addMinutes(10));
Passport::refreshTokensExpireIn(\Carbon\Carbon::now()->addDays(10));
```

In BroadcastServiceProvider add the following in boot method
``` bash
Broadcast::routes(['middleware' => ['auth:api']]);
```

In app.php uncomment the following
``` bash
App\Providers\BroadcastServiceProvider::class,
```

api documentation

add this command to console kernel.php
``` bash
use \App\Modules\Core\Console\Commands\GenerateDoc as GenerateDoc;
use App\Modules\Notifications\Console\Commands\MakeNotificationsCommand as MakeNotificationsCommand;
protected $commands = [
    GenerateDoc::class,
    MakeNotificationsCommand::class
];
```
then run 
``` bash
php artisan doc:generate
```

## Usage
Check the [wiki][link-wiki].

## Credits

- [Sherif Elfadaly][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/api-skeleton/api-skeleton.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-scrutinizer-build]: https://scrutinizer-ci.com/g/SherifElfadaly/Laravel-Api-Skeleton/badges/build.png?b=master
[ico-scrutinizer]: https://scrutinizer-ci.com/g/SherifElfadaly/Laravel-Api-Skeleton/badges/quality-score.png?b=master
[ico-downloads]: https://img.shields.io/packagist/dt/api-skeleton/api-skeleton.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/api-skeleton/api-skeleton
[link-scrutinizer-build]: https://scrutinizer-ci.com/g/SherifElfadaly/Laravel-Api-Skeleton/
[link-scrutinizer]: https://scrutinizer-ci.com/g/SherifElfadaly/Laravel-Api-Skeleton/code-structure
[link-downloads]: https://packagist.org/packages/api-skeleton/api-skeleton
[link-author]: https://github.com/SherifElfadaly
[link-contributors]: ../../contributors 
[link-wiki]: https://github.com/SherifElfadaly/Laravel-Api-Skeleton/wiki