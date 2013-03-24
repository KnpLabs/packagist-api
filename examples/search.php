<?php

require __DIR__.'/../vendor/autoload.php';

$client = new Packagist\Api\Client();
$results = $client->search('sylius');

var_export($results);
