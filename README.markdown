# Packagist API

Simple object oriented wrapper for Packagist API.

## Installation

The recommended way to install Packagist API is through composer:

```js
{
    "require": {
        "knplabs/packagist-api": "*"
    }
}
```

## Usage

Search for packages:

```php
<?php

$packagist = new Packagist\Packagist();
$results = $packagist->search('sylius');

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

$packagist = new Packagist\Packagist();
$packages = $packagist->get('sylius/sylius');
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

$packagist = new Packagist\Packagist();
$packages = $packagist->all();

foreach ($packages as $package) {
    echo $package;
}

// Outputs:
abhinavsingh/jaxl
abishekrsrikaanth/fuel-util
abmundi/database-commands-bundle
...
```
