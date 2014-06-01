<?php

namespace Packagist\Api;

use Guzzle\Http\ClientInterface;
use Packagist\Api\Result\Factory;

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
     * @return array
     */
    public function search($query, array $filters = array())
    {
        $results = $response = array();
        $filters['q'] = $query;
        $url = '/search.json?' . http_build_query($filters);
        $response['next'] = $this->url($url);

        do {
            $response = $this->request($response['next']);
            $response = $this->parse($response);
            $results = array_merge($results, $this->create($response));
        } while (isset($response['next']));

        return $results;
    }

    public function get($package)
    {
        return $this->respond(sprintf($this->url('/packages/%s.json'), $package));
    }

    public function all(array $filters = array())
    {
        $url = '/packages/list.json';
        if ($filters) {
            $url .= '?'.http_build_query($filters);
        }

        return $this->respond($this->url($url));
    }

    /**
     * @param string $url
     * @return string
     */
    private function url($url)
    {
        return $this->packagistUrl . $url;
    }

    /**
     * @param unknown $url
     * @return \Packagist\Api\Result\ResultCollection, \Packagist\Api\Result\Package, string
     */
    private function respond($url)
    {
        $response = $this->request($url);
        $response = $this->parse($response);

        return $this->create($response);
    }

    /**
     * @param string $url
     */
    private function request($url)
    {
        return $this->httpClient
                    ->get($url)
                    ->send()
                    ->getBody(true);
    }

    /**
     * @param string $data
     * @return array
     */
    private function parse($data)
    {
        return json_decode($data, true);
    }



    private function create(array $data)
    {
        return $this->resultFactory->create($data);
    }

    /**
     * @return string
     */
    public function getPackagistUrl()
    {
        return $this->packagistUrl;
    }
}
