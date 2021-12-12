# Openfoodfacts: Search Products Module

## Installation

Install:
* https://github.com/nWidart/laravel-modules
* https://github.com/joshbrw/laravel-module-installer

Run commands:
```sh
cd [your laravel project]
```
```sh
composer require mgalkina/openfoodfactssearchproducts-module
```
```sh
php artisan module:migrate Openfoodfactssearchproducts
```
```sh
cd .\Modules\Openfoodfactssearchproducts\
```
```sh
npm install
```
```sh
npm run production
```
Enable the module:
```sh
php artisan module:enable Openfoodfactssearchproducts
```

Module page:
```sh
https://[your host name]/openfoodfactssearchproducts
```

## Tests

Add to phpunit.xml:
```sh
<testsuite name="Feature">
    <directory suffix="Test.php">./Modules/**/Tests/Feature</directory>
</testsuite>

<testsuite name="Unit">
    <directory suffix="Test.php">./Modules/**/Tests/Unit</directory>
</testsuite>
```
Run tests:
```sh
php artisan test
```

## License

MIT