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

publish files

``` bash
php artisan vendor:publish --force
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
run 
``` bash
php artisan doc:generate
```
Install php code sniffer
``` bash
composer require --dev squizlabs/php_codesniffer
```
Add php code sniffer command to composer.json
``` bash
"phpcs" :"./vendor/bin/phpcs ./",
"phpcbf" :"./vendor/bin/phpcbf ./",
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