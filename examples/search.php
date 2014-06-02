<?php

use Packagist\Api\Filter;
use Packagist\Api\PackagistApiClientFactory;

require __DIR__.'/../vendor/autoload.php';

$client = PackagistApiClientFactory::getInstance();

$filter = new Filter();
$filter->addTag('api')
       ->addTag('doctrine')
       ->setVendor("sylius")
       ->setType("library");

$results = $client->search('sylius');

var_export($results);
