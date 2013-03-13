<?php

require __DIR__.'/../vendor/autoload.php';

$packagist = new Packagist\Packagist();
$results = $packagist->search('sylius');

var_dump($results);
