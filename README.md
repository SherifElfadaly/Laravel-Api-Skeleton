This package is under development
<!-- # Api Skeleton

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
"api-skeleton/api-skeleton": "^1.0@dev"
```
Then add the service provider in config/app.php:

``` bash
ApiSkeleton\ApiSkeleton\ApiSkeletonServiceProvider::class,
Caffeinated\Modules\ModulesServiceProvider::class,
Tymon\JWTAuth\Providers\JWTAuthServiceProvider::class,
```
add the aliases in config/app.php

``` bash
'Core'         => App\Modules\Core\Facades\Core::class,
'ErrorHandler' => App\Modules\Core\Facades\ErrorHandler::class,
'CoreConfig'   => App\Modules\Core\Facades\CoreConfig::class,
'Logging'      => App\Modules\Core\Facades\Logging::class,
'Module'       => Caffeinated\Modules\Facades\Module::class,
'JWTAuth'      => Tymon\JWTAuth\Facades\JWTAuth::class
'JWTFactory'   => Tymon\JWTAuth\Facades\JWTFactory::class
```

add the following code in Exception/Handler.php

``` bash
if ($request->wantsJson())
{
	if ($e instanceof \Illuminate\Database\QueryException) 
	{
		$error = \ErrorHandler::dbQueryError();
		return \Response::json($error['message'], $error['status']);
	}
	else if ($e instanceof \predis\connection\connectionexception) 
	{
		$error = \ErrorHandler::redisNotRunning();
		return \Response::json($error['message'], $error['status']);
	}
	else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) 
	{
		$error = \ErrorHandler::tokenExpired();
		return \Response::json($error['message'], $error['status']);
	} 
	else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) 
	{
		$error = \ErrorHandler::noPermissions();
		return \Response::json($error['message'], $error['status']);
	}
	else if ($e instanceof \Tymon\JWTAuth\Exceptions\JWTException) 
	{
		$error = \ErrorHandler::unAuthorized();
		return \Response::json($error['message'], $error['status']);
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

``` bash
php artisan jwt:generate
```

## Usage

``` php
Coming soon
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email sh.elfadaly@gmail.com instead of using the issue tracker.

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
[link-contributors]: ../../contributors -->