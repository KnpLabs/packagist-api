<?php

require __DIR__.'/../vendor/autoload.php';

$client = Packagist\Api\PackagistApiClientFactory::getInstance();
$results = $client->search('sylius');

var_export($results);
