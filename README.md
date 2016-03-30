# Api Skeleton

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
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
```
add the aliases config/app.php

``` bash
'Core'         => App\Modules\Core\Facades\Core::class,
'ErrorHandler' => App\Modules\Core\Facades\ErrorHandler::class,
'CoreConfig'   => App\Modules\Core\Facades\CoreConfig::class,
'Module'       => Caffeinated\Modules\Facades\Module::class,
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
[ico-travis]: https://travis-ci.org/SherifElfadaly/Laravel-Api-Skeleton.svg?branch=master
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/api-skeleton/api-skeleton.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/api-skeleton/api-skeleton.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/api-skeleton/api-skeleton.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/api-skeleton/api-skeleton
[link-travis]: https://travis-ci.org/api-skeleton/api-skeleton
[link-scrutinizer]: https://scrutinizer-ci.com/g/api-skeleton/api-skeleton/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/api-skeleton/api-skeleton
[link-downloads]: https://packagist.org/packages/api-skeleton/api-skeleton
[link-author]: https://github.com/SherifElfadaly
[link-contributors]: ../../contributors
