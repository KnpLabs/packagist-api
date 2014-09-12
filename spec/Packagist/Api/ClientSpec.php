<?php

namespace spec\Packagist\Api;

use PhpSpec\ObjectBehavior;
use PhpSpec\Exception\Example\MatcherException;

use Packagist\Api\Client;
use Packagist\Api\Result\Factory;
use Guzzle\Http\Message\Request;
use Guzzle\Http\Message\Response;
use Guzzle\Http\Client as HttpClient;

class ClientSpec extends ObjectBehavior
{
    function let(HttpClient $client, Factory $factory, Request $request, Response $response)
    {
        $this->beConstructedWith($client, $factory);

        $request->send()->willReturn($response);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Packagist\Api\Client');
    }

    function it_search_for_packages(HttpClient $client, Factory $factory, Request $request, Response $response)
    {
        $client->get('https://packagist.org/search.json?q=sylius')->shouldBeCalled()->willReturn($request);
        $data = file_get_contents('spec/Packagist/Api/Fixture/search.json');
        $response->getBody(true)->shouldBeCalled()->willReturn($data);
        $factory->create(json_decode($data, true))->shouldBeCalled()->willReturn(array());

        $this->search('sylius');
    }

    function it_searches_for_packages_with_filters(HttpClient $client, Factory $factory, Request $request, Response $response)
    {
        $client->get('https://packagist.org/search.json?tag=storage&q=sylius')->shouldBeCalled()->willReturn($request);
        $data = file_get_contents('spec/Packagist/Api/Fixture/search.json');
        $response->getBody(true)->shouldBeCalled()->willReturn($data);
        $factory->create(json_decode($data, true))->shouldBeCalled()->willReturn(array());

        $this->search('sylius', array('tag' => 'storage'));
    }

    function it_gets_package_details(HttpClient $client, Factory $factory, Request $request, Response $response)
    {
        $client->get('https://packagist.org/packages/sylius/sylius.json')->shouldBeCalled()->willReturn($request);
        $data = file_get_contents('spec/Packagist/Api/Fixture/get.json');
        $response->getBody(true)->shouldBeCalled()->willReturn($data);
        $factory->create(json_decode($data, true))->shouldBeCalled();

        $this->get('sylius/sylius');
    }

    function it_lists_all_package_names(HttpClient $client, Factory $factory, Request $request, Response $response)
    {
        $client->get('https://packagist.org/packages/list.json')->shouldBeCalled()->willReturn($request);
        $data = file_get_contents('spec/Packagist/Api/Fixture/all.json');
        $response->getBody(true)->shouldBeCalled()->willReturn($data);
        $factory->create(json_decode($data, true))->shouldBeCalled();

        $this->all();
    }

    function it_filters_package_names_by_type(HttpClient $client, Factory $factory, Request $request, Response $response)
    {
        $client->get('https://packagist.org/packages/list.json?type=library')->shouldBeCalled()->willReturn($request);
        $data = file_get_contents('spec/Packagist/Api/Fixture/all.json');
        $response->getBody(true)->shouldBeCalled()->willReturn($data);
        $factory->create(json_decode($data, true))->shouldBeCalled();

        $this->all(array('type' => 'library'));
    }

    function it_filters_package_names_by_vendor(HttpClient $client, Factory $factory, Request $request, Response $response)
    {
        $client->get('https://packagist.org/packages/list.json?vendor=sylius')->shouldBeCalled()->willReturn($request);
        $data = file_get_contents('spec/Packagist/Api/Fixture/all.json');
        $response->getBody(true)->shouldBeCalled()->willReturn($data);
        $factory->create(json_decode($data, true))->shouldBeCalled();

        $this->all(array('vendor' => 'sylius'));
    }
}
