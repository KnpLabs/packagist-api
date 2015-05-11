# Packagist API [![Build Status](https://travis-ci.org/KnpLabs/packagist-api.svg)](https://travis-ci.org/KnpLabs/packagist-api) [![HHVM Status](http://hhvm.h4cc.de/badge/knplabs/packagist-api.svg)](http://hhvm.h4cc.de/package/knplabs/packagist-api) [![Latest Stable Version](https://poser.pugx.org/KnpLabs/packagist-api/v/stable.png)](https://packagist.org/packages/KnpLabs/packagist-api) [![Total Downloads](https://poser.pugx.org/KnpLabs/packagist-api/downloads.png)](https://packagist.org/packages/KnpLabs/packagist-api)
[![Dependency Status](https://www.versioneye.com/php/knplabs:packagist-api/badge.svg)](https://www.versioneye.com/php/knplabs:packagist-api)
[![Reference Status](https://www.versioneye.com/php/knplabs:packagist-api/reference_badge.svg?style=flat)](https://www.versioneye.com/php/knplabs:packagist-api/references)

Simple object oriented wrapper for Packagist API.

## Installation

The recommended way to install Packagist API is through composer:

```json
{
    "require": {
        "knplabs/packagist-api": "1.*@dev"
    }
}
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

#### Get package details:

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

#### Custom Packagist Repositories

You can also set a custom Packagist Repository URL:

```php
<?php

$client->setPackagistUrl('https://custom.packagist.site.org');
```

## License

`packagist-api` is licensed under the MIT License - see the LICENSE file for details.
