<?php

namespace spec\Packagist\Api;

use Prophecy\Argument;
use PhpSpec\ObjectBehavior;
use PhpSpec\Exception\Example\MatcherException;
use Packagist\Api\PackagistApiClient;
use Packagist\Api\Result\Factory;
use Guzzle\Http\Message\Request;
use Guzzle\Http\Message\Response;
use Guzzle\Http\Client;

class PackagistApiClientSpec extends ObjectBehavior
{
    public function let(Client $client, Factory $factory, Request $request, Response $response)
    {
        $this->beConstructedWith($client, $factory, "https://packagist.org");

        $request->send()->willReturn($response);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Packagist\Api\PackagistApiClient');
    }

    /**
     * @param string $name
     * @return string
     */
    private static function load($name)
    {
    	return file_get_contents(__DIR__ . '/Fixture/' . $name);
    }

    public function it_search_for_packages(Client $client, Factory $factory, Request $request, Response $response)
    {
    	$client->get('https://packagist.org/search.json?q=sylius')->shouldBeCalled()->willReturn($client);
    	$client->send()->shouldBeCalled()->willReturn($response);
    	$data = self::load('search.json');
    	$response->getBody(true)->shouldBeCalled()->willReturn($data);
        //$this->get('https://packagist.org/search.json?q=sylius')->shouldBeCalled()->willReturn($request);


        $factory->create(json_decode($data, true))->shouldBeCalled()->willReturn(array());

        $this->search('sylius');
    }

    function it_searches_for_packages_with_filters($client, $factory, $request, $response)
    {
        $client->get('https://packagist.org/search.json?tag=storage&q=sylius')->shouldBeCalled()->willReturn($request);
        $data = self::load('search.json');
        $response->getBody(true)->shouldBeCalled()->willReturn($data);
        $factory->create(json_decode($data, true))->shouldBeCalled()->willReturn(array());

        $this->search('sylius', array('tag' => 'storage'));
    }

    function it_gets_package_details($client, $factory, $request, $response)
    {
        $client->get('https://packagist.org/packages/sylius/sylius.json')->shouldBeCalled()->willReturn($request);
        $data = self::load('get.json');
        $response->getBody(true)->shouldBeCalled()->willReturn($data);
        $factory->create(json_decode($data, true))->shouldBeCalled();

        $this->get('sylius/sylius');
    }

    function it_lists_all_package_names($client, $factory, $request, $response)
    {
        $client->get('https://packagist.org/packages/list.json')->shouldBeCalled()->willReturn($request);
        $data = self::load('all.json');
        $response->getBody(true)->shouldBeCalled()->willReturn($data);
        $factory->create(json_decode($data, true))->shouldBeCalled();

        $this->all();
    }

    function it_filters_package_names_by_type($client, $factory, $request, $response)
    {
        $client->get('https://packagist.org/packages/list.json?type=library')->shouldBeCalled()->willReturn($request);
        $data = self::load('all.json');
        $response->getBody(true)->shouldBeCalled()->willReturn($data);
        $factory->create(json_decode($data, true))->shouldBeCalled();

        $this->all(array('type' => 'library'));
    }

    function it_filters_package_names_by_vendor($client, $factory, $request, $response)
    {
        $client->get('https://packagist.org/packages/list.json?vendor=sylius')->shouldBeCalled()->willReturn($request);
        $data = self::load('all.json');
        $response->getBody(true)->shouldBeCalled()->willReturn($data);
        $factory->create(json_decode($data, true))->shouldBeCalled();

        $this->all(array('vendor' => 'sylius'));
    }
}
