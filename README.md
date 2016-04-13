# Api Skeleton

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-scrutinizer-build]][link-scrutinizer-build]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Total Downloads][ico-downloads]][link-downloads]

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what
PSRs you support to avoid any confusion with users and contributors.

## Install

Via Composer

add this line to composer.json:
``` bash
composer require api-skeleton/api-skeleton
```
Then add the service provider in config/app.php:

``` bash
ApiSkeleton\ApiSkeleton\ApiSkeletonServiceProvider::class,
Caffeinated\Modules\ModulesServiceProvider::class,
Tymon\JWTAuth\Providers\JWTAuthServiceProvider::class,
Davibennun\LaravelPushNotification\LaravelPushNotificationServiceProvider::class,
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
```

add the following code in Exception/Handler.php in render function before the return

``` bash
if ($request->wantsJson())
{
    if ($e instanceof \Illuminate\Database\QueryException) 
    {
        \ErrorHandler::dbQueryError();
    }
    else if ($e instanceof \predis\connection\connectionexception) 
    {
        \ErrorHandler::redisNotRunning();
    }
    else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) 
    {
        \ErrorHandler::tokenExpired();
    } 
    else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) 
    {
        \ErrorHandler::tokenExpired();
    }
    else if ($e instanceof \Tymon\JWTAuth\Exceptions\JWTException) 
    {
        \ErrorHandler::unAuthorized();
    }
    else if ($e instanceof HttpException) 
    {
        return \Response::json($e->getMessage(), $e->getStatusCode());   
    }
    else
    {
        return parent::render($request, $e);
    }
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
 set a secret key in the config file

Update the namespace and path in modules.php config

``` bash
'path'      => app_path('Modules/V1'),
'namespace' => 'App\Modules\V1\\',
```

``` bash
php artisan jwt:generate
```

## Usage
Check the [wiki][link-wiki].

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

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