<?php

require __DIR__.'/../vendor/autoload.php';

$packagist = new Packagist\Packagist();
$packages = $packagist->all();

var_dump($packages);
