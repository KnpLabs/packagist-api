# Packagist API [![Build Status](https://travis-ci.org/KnpLabs/packagist-api.png)](https://travis-ci.org/KnpLabs/packagist-api)

Simple object oriented wrapper for Packagist API.

## Installation

The recommended way to install Packagist API is through composer:

```js
{
    "require": {
        "knplabs/packagist-api": "0.1.*"
    }
}
```

## Usage

Search for packages:

```php
<?php

$client = new Packagist\Api\Client();
$results = $client->search('sylius');

foreach ($results as $result) {
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

Get package details:

```php
<?php

$client = new Packagist\Api\Client();
$packages = $client->get('sylius/sylius');
$package = $packages['dev-master'];

printf(
    'Package %s. %s. Read more on %s.',
    $package->getName(),
    $package->getDescription(),
    $package->getHomepage()
);

// Outputs:
Package sylius/sylius. Modern ecommerce for Symfony2. Read more on http://sylius.org.
```

List all packages:

```php
<?php

$client = new Packagist\Api\Client();
$packages = $client->all();

foreach ($packages as $package) {
    echo $package;
}

// Outputs:
abhinavsingh/jaxl
abishekrsrikaanth/fuel-util
abmundi/database-commands-bundle
...
```
