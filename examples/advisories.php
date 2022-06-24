<?php

require __DIR__ . '/../vendor/autoload.php';

$client = new Packagist\Api\Client();

// Get any advisories for the monolog/monolog package
$advisories = $client->advisories(['monolog/monolog']);
var_export($advisories);

// Get any advisories for the monolog/monolog package which were modified after midnight 2022/07/2022.
$advisories = $client->advisories(['monolog/monolog' => '1.8.1'], 1659052800);
var_export($advisories);

// Get any advisories for the monolog/monolog package which will affect version 1.8.1 of that package
$advisories = $client->advisories(['monolog/monolog' => '1.8.1'], null, true);
var_export($advisories);
