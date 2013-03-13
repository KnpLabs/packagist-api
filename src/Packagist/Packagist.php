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
        return $this->response('/search.json?q='.$query);
    }

    public function get($package)
    {
        return $this->response(sprintf('/p/%s.json', $package));
    }

    public function all()
    {
        return $this->response('/packages/list.json');
    }

    protected function response($url)
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
            ->get('https://packagist.org'.$url)
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
