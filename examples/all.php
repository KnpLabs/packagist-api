<?php

use Packagist\Api\PackagistApiClientFactory;
require __DIR__.'/../vendor/autoload.php';

$client = Packagist\Api\PackagistApiClientFactory::getInstance();
$packages = $client->all();

var_export($packages);
