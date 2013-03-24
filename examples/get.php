<?php

require __DIR__.'/../vendor/autoload.php';

$client = new Packagist\Api\Client();
$package = $client->get('sylius/sylius');

var_export($package);
