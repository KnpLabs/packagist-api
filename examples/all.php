<?php

require __DIR__.'/../vendor/autoload.php';

$client = new Packagist\Api\Client();
$packages = $client->all();

var_export($packages);
