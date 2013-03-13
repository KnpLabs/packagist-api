<?php

require __DIR__.'/../vendor/autoload.php';

$packagist = new Packagist\Packagist();
$results = $packagist->get('sylius/sylius');

var_dump($results);
