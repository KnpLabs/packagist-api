<?php

namespace Packagist\Api;

use Guzzle\Http\Client as HttpClient;
use Guzzle\Http\ClientInterface;
use Packagist\Api\Result\Factory;

class Client
{
    protected $httpClient;
    protected $resultFactory;
    protected $packagistUrl;

    public function __construct(ClientInterface $httpClient = null, Factory $resultFactory = null, $packagistUrl = "https://packagist.org")
    {
        $this->httpClient = $httpClient;
        $this->resultFactory = $resultFactory;
        $this->packagistUrl = $packagistUrl;
    }

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

    protected function url($url)
    {
        return $this->packagistUrl.$url;
    }

    protected function respond($url)
    {
        $response = $this->request($url);
        $response = $this->parse($response);

        return $this->create($response);
    }

    protected function request($url)
    {
        if (null === $this->httpClient) {
            $this->httpClient = new HttpClient();
        }

        return $this->httpClient
            ->get($url)
            ->send()
            ->getBody(true)
        ;
    }

    protected function parse($data)
    {
        return json_decode($data, true);
    }

    protected function create(array $data)
    {
        if (null === $this->resultFactory) {
            $this->resultFactory = new Factory();
        }

        return $this->resultFactory->create($data);
    }

    /**
     * @param string $packagistUrl
     */
    public function setPackagistUrl($packagistUrl)
    {
        $this->packagistUrl = $packagistUrl;
    }

    /**
     * @return string
     */
    public function getPackagistUrl()
    {
        return $this->packagistUrl;
    }
}
