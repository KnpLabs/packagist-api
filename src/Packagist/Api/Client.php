<?php

namespace Packagist\Api;

use Guzzle\Http\Client as HttpClient;
use Guzzle\Http\ClientInterface;
use Packagist\Api\Result\Factory;

class Client
{
    protected $httpClient;
    protected $resultFactory;

    public function __construct(ClientInterface $httpClient = null, Factory $resultFactory = null)
    {
        $this->httpClient = $httpClient;
        $this->resultFactory = $resultFactory;
    }

    public function search($query)
    {
        $results = $response = array();
        $response['next'] = $this->url('/search.json?q='.$query);

        do {
            $response = $this->request($response['next']);
            $response = $this->parse($response);
            $results = array_merge($results, $this->create($response));
        } while (isset($response['next']));

        return $results;
    }

    public function get($package)
    {
        return $this->respond(sprintf($this->url('/p/%s.json'), $package));
    }

    public function all()
    {
        return $this->respond($this->url('/packages/list.json'));
    }

    protected function url($url)
    {
        return 'https://packagist.org'.$url;
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
}
