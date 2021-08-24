<?php

require __DIR__.'/../vendor/autoload.php';

$client = new Packagist\Api\Client();
$package = $client->getComposerLite('sylius/sylius');

var_export($package);
