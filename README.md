# Api Skeleton

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-scrutinizer-build]][link-scrutinizer-build]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Total Downloads][ico-downloads]][link-downloads]
## Install

Add this to cpmposer.json
``` bash
"minimum-stability" : "dev",
"prefer-stable": true
```

Via Composer

Run this command:
``` bash
composer require api-skeleton/api-skeleton
```
then add the service provider in config/app.php:

``` bash
ApiSkeleton\ApiSkeleton\ApiSkeletonServiceProvider::class,
Caffeinated\Modules\ModulesServiceProvider::class,
Tymon\JWTAuth\Providers\JWTAuthServiceProvider::class,
Davibennun\LaravelPushNotification\LaravelPushNotificationServiceProvider::class,
Laravel\Socialite\SocialiteServiceProvider::class,
```
add the aliases in config/app.php

``` bash
'Core'             => App\Modules\V1\Core\Facades\Core::class,
'ErrorHandler'     => App\Modules\V1\Core\Facades\ErrorHandler::class,
'CoreConfig'       => App\Modules\V1\Core\Facades\CoreConfig::class,
'Logging'          => App\Modules\V1\Core\Facades\Logging::class,
'Module'           => Caffeinated\Modules\Facades\Module::class,
'JWTAuth'          => Tymon\JWTAuth\Facades\JWTAuth::class,
'JWTFactory'       => Tymon\JWTAuth\Facades\JWTFactory::class,
'PushNotification' => Davibennun\LaravelPushNotification\Facades\PushNotification::class,
'Socialite'        => Laravel\Socialite\Facades\Socialite::class,
```

add the following code in Exception/Handler.php in render function

``` bash
if ($request->wantsJson())
{
    if ($exception instanceof \Illuminate\Database\QueryException) 
    {
        \ErrorHandler::dbQueryError();
    }
    else if ($exception instanceof \predis\connection\connectionexception) 
    {
        \ErrorHandler::redisNotRunning();
    }
    else if ($exception instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) 
    {
        \ErrorHandler::tokenExpired();
    } 
    else if ($exception instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) 
    {
        \ErrorHandler::tokenExpired();
    }
    else if ($exception instanceof \Tymon\JWTAuth\Exceptions\JWTException) 
    {
        \ErrorHandler::unAuthorized();
    }
    else if ($exception instanceof \GuzzleHttp\Exception\ClientException) 
    {
        \ErrorHandler::connectionError();
    }
    else if ($exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException) 
    {
        return \Response::json($exception->getMessage(), $exception->getStatusCode());   
    }
    else if ($exception instanceof \lluminate\Validation\ValidationException) 
    {
        return \Response::json($exception->getMessage(), $exception->getStatusCode());   
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
commit the csrf check in App\Http\Kernel.php

``` bash
//\App\Http\Middleware\VerifyCsrfToken::class,
```
publish files

``` bash
php artisan vendor:publish
```

update the namespace and path in modules.php config

``` bash
'path'      => app_path('Modules/V1'),
'namespace' => 'App\Modules\V1\\',
```

set a secret key in the config file
``` bash
php artisan jwt:generate
```

run this command
``` bash
php artisan module:optimize
```

run database migrations
``` bash
php artisan module:migrate
```

api documentation
``` bash
install apidocjs http://apidocjs.com/
edit apidoc.json in myapp/Modules
run apidoc -i myapp/Modules -o apidoc/
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