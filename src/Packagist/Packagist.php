<?php

namespace Packagist;

use Guzzle\Http\Client;
use Guzzle\Http\ClientInterface;
use Packagist\Result\Factory;
use Packagist\Result\FactoryInterface;

class Packagist
{
    protected $client;
    protected $factory;

    public function __construct(ClientInterface $client = null, FactoryInterface $factory = null)
    {
        $this->client = $client;
        $this->factory = $factory;
    }

    public function search($query)
    {
        $results = $response = array();
        $response['next'] = $this->url('/search.json?q='.$query);

        do {
            $response = $this->request($response['next']);
            $response = $this->parse($response);
            $results = array_merge($results, $this->create($response));
        } while(isset($response['next']));

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
        if (null === $this->client) {
            $this->client = new Client();
        }

        return $this->client
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
        if (null === $this->factory) {
            $this->factory = new Factory();
        }

        return $this->factory->create($data);
    }
}
