<?php

require __DIR__.'/../vendor/autoload.php';

$client = new Packagist\Api\Client();
$results = $client->popular(100);

var_export($results);
