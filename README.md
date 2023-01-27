# AdminKit Directories Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/admin-kit/directories.svg?style=flat-square)](https://packagist.org/packages/admin-kit/directories)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/admin-kit/directories/run-tests.yml?branch=1.x&label=tests&style=flat-square)](https://github.com/admin-kit/directories/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/admin-kit/directories/fix-php-code-style-issues.yml?branch=1.x&label=code%20style&style=flat-square)](https://github.com/admin-kit/directories/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/admin-kit/directories.svg?style=flat-square)](https://packagist.org/packages/admin-kit/directories)

Пакет для создания справочников

## Installation

You can install the package via composer:

```bash
composer require admin-kit/directories
```

Добавить меню в `PlatformProvider.php`
```php
public function registerMainMenu(): array
{
    // ...

    Menu::make(__('Directories'))
        ->icon('folder-alt')
        ->route('platform.directories'),
}
```

Опубликовать миграции:

```bash
php artisan vendor:publish --tag="directories-migrations"
php artisan migrate
```

## Usage

Пример, чтобы создать новый справочник, необходимо выполнить следующие условия:

Создать модель `City`:
```php
php artisan admin-kit:directories-model City
```

Добавить в конфиг файла `config/admin-kit.php`
```php
'packages' => [
    'directories' => [
        // ...
        'models' => [
            'City' => 'Город',
        ],
    ],
],
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Anastas Mironov](https://github.com/ast21)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
