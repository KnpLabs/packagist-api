<?php

require __DIR__.'/../vendor/autoload.php';

$client = Packagist\Api\PackagistApiClientFactory::getInstance();
$package = $client->get('sylius/sylius');

var_export($package);
