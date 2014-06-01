<?php

namespace Packagist\Api;

use Guzzle\Http\Client;
use Packagist\Api\Result\Factory;


class PackagistApiClientFactory
{
    /**
     * @param string $packagistUrl
     * @return \Packagist\Api\PackagistApiClient
     */
    public static function getInstance($packagistUrl = "https://packagist.org")
    {
        return new PackagistApiClient(
            new Client(),
            new Factory(),
            $packagistUrl
        );
    }
}
