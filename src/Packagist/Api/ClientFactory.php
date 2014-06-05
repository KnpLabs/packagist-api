<?php

namespace Packagist\Api;

use Guzzle\Http\Client as HttpClient;
use Packagist\Api\Result\Factory;

class ClientFactory
{
    /**
     * Create instance of PackagistApiClient
     *
     * @param null|ClientInterface $httpClient
     * @param string               $packagistUrl
     *
     * @return \Packagist\Api\Client
     */
    public static function getInstance(
        ClientInterface $httpClient = null,
        $packagistUrl = "https://packagist.org"
    )
    {
        if ($httpClient === null) {
            $httpClient = new HttpClient();
        }

        return new Client(
            new HttpClient(),
            new Factory(),
            $packagistUrl
        );
    }
}
