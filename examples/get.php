<?php

require __DIR__.'/../vendor/autoload.php';

$client = new Packagist\Api\Client();
$results = $client->get('sylius/sylius');

var_dump($results);
