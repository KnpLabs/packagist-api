<?php

require __DIR__.'/../vendor/autoload.php';

$client = new Packagist\Api\Client();
$package = $client->getComposerReleases('sylius/sylius');

var_export($package);
