# Packagist API

![Build status](https://github.com/KnpLabs/packagist-api/actions/workflows/test.yml/badge.svg) [![Latest Stable Version](https://poser.pugx.org/KnpLabs/packagist-api/v/stable.png)](https://packagist.org/packages/KnpLabs/packagist-api) [![Total Downloads](https://poser.pugx.org/KnpLabs/packagist-api/downloads.png)](https://packagist.org/packages/KnpLabs/packagist-api)

Simple object oriented wrapper for Packagist API.

## Requirements

* PHP ^7.4 or ^8.0 (for PHP 7.1-7.3 please use the 1.x release line)

## Installation

The recommended way to install Packagist API is through composer:

```bash
$ composer require knplabs/packagist-api
```

## Usage

#### Search for packages:

```php
<?php

$client = new Packagist\Api\Client();

foreach ($client->search('sylius') as $result) {
    echo $result->getName();
}

// Outputs:
sylius/sylius
sylius/resource-bundle
sylius/cart-bundle
sylius/flow-bundle
sylius/sales-bundle
sylius/shipping-bundle
sylius/taxation-bundle
sylius/money-bundle
sylius/assortment-bundle
sylius/addressing-bundle
sylius/payments-bundle
sylius/taxonomies-bundle
sylius/inventory-bundle
sylius/settings-bundle
sylius/promotions-bundle
...
```

#### You can limit results to a desired amount of pages:

```php
<?php

$client->search('sylius', [], 2)  // get first 2 pages
```

#### Get package details:

Gets full package details, generated dynamically by the Packagist API.
Consider using [getComposer()](#get-composer-details)
instead to use the Packagist API more efficiently if you don't need all
the full metadata for a package.

```php
<?php

$package = $client->get('sylius/sylius');

printf(
    'Package %s. %s.',
    $package->getName(),
    $package->getDescription()
);

// Outputs:
Package sylius/sylius. Modern ecommerce for Symfony2.
```

#### Get composer details: {#get-composer-details}

Similar to `get()`, but uses Composer metadata which is Packagist's preferred
way of retrieving details, since responses are cached efficiently as static files
by the Packagist service. The response lacks some metadata that is provided
by `get()`, see [Packagist API documentation](https://packagist.org/apidoc)
for details. Returns multiple packages, you need to select the requested
one from the indexed array.

```php
<?php

$packages = $client->getComposer('sylius/sylius');
$package = $packages['sylius/sylius'];
$versions = $package->getVersions();

printf(
    'Package %s. %s.',
    $versions[0]->getName(),
    $versions[0]->getDescription()
);

// Outputs:
Package sylius/sylius. Modern ecommerce for Symfony2.
```

#### List all packages:

```php
<?php

foreach ($client->all() as $package) {
    echo $package;
}

// Outputs:
abhinavsingh/jaxl
abishekrsrikaanth/fuel-util
abmundi/database-commands-bundle
...
```

#### They can be filtered by type or vendor:

```php
<?php

$client->all(array('type' => 'library'));
$client->all(array('vendor' => 'sylius'));
```

#### Custom Packagist repositories

You can also set a custom Packagist repository URL:

```php
<?php

$client->setPackagistUrl('https://custom.packagist.site.org');
```

## Errors

* A `Packagist\Api\PackageNotFoundException` will be thrown when the Packagist API returns a 404 response.
* An `\InvalidArgumentException` will be thrown when the response from Packagist was not able to be parsed.

## License

`packagist-api` is licensed under the MIT License - see the LICENSE file for details.

## Maintainers

KNPLabs is looking for maintainers ([see why](https://knplabs.com/en/blog/news-for-our-foss-projects-maintenance)).

If you are interested, feel free to open a PR to ask to be added as a maintainer.

We’ll be glad to hear from you :)

This library is maintained by the following people (alphabetically sorted) :
- @robbieaverill
