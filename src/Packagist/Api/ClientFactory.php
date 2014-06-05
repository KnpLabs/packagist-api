<?php

namespace Packagist\Api;

use Guzzle\Http\Client as HttpClient;
use Packagist\Api\Result\Factory;

class ClientFactory
{
    /**
     * Create instance of PackagistApiClient
     *
     * @param string $packagistUrl
     *
     * @return \Packagist\Api\Client
     */
    public static function getInstance($packagistUrl = "https://packagist.org")
    {
        return new Client(
            new HttpClient(),
            new Factory(),
            $packagistUrl
        );
    }
}
