<?php

namespace Packagist\Api;

use Guzzle\Http\ClientInterface;
use Packagist\Api\Result\Factory;
use Packagist\Api\Result\ResultCollection;

class PackagistApiClient
{
    /**
     * @var ClientInterface
     */
    private $httpClient = null;
    /**
     * @var Factory
     */
    private $resultFactory = null;
    /**
     * @var string
     */
    private $packagistUrl = null;

    /**
     * @param ClientInterface $httpClient
     * @param Factory $resultFactory
     * @param string $packagistUrl
     */
    public function __construct(ClientInterface $httpClient, Factory $resultFactory, $packagistUrl)
    {
        $this->httpClient = $httpClient;
        $this->resultFactory = $resultFactory;
        $this->packagistUrl = $packagistUrl;
    }

    /**
     * @param string $query
     * @param array $filters
     * @return \Packagist\Api\Result\ResultCollection
     */
    public function search($query, array $filters = array())
    {
        $filters['q']     = $query;
        $url              = '/search.json?' . http_build_query($filters);
        $response         = array();
        $response['next'] = $url;
        $resultCollection = new ResultCollection();

        do {
            $response = $this->parseRequestResponse($this->request($response['next']));
            $resultCollection = $this->resultFactory->createSearchResults($resultCollection, $response);
        } while (isset($response['next']));

        return $resultCollection;
    }

    /**
     * @param string $package
     * @return \Packagist\Api\Result\Package
     */
    public function get($package)
    {
        return $this->resultFactory->createPackageResults(
            $this->parseRequestResponse(
                $this->request(
                    sprintf('/packages/%s.json', $package)
                )
            )
        );
    }

    /**
     * @param array $filters
     * @return array
     */
    public function all(array $filters = array())
    {
        $url = '/packages/list.json';
        if (!empty($filters)) {
            $url .= '?'.http_build_query($filters);
        }

        return $this->resultFactory->createSimpleResults(
            $this->parseRequestResponse($this->request($url))
        );
    }

    /**
     * @param string $url
     * @return string
     */
    private function request($url)
    {
        return $this->httpClient->get((strpos($url, 'http') === false) ? $this->packagistUrl . $url : $url)
                                ->send()
                                ->getBody(true);
    }

    /**
     * @param string $response
     * @return array
     */
    private function parseRequestResponse($response)
    {
        return json_decode($response, true);
    }
}
