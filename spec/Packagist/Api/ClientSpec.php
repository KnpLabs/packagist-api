<?php

namespace spec\Packagist\Api;

use PhpSpec\ObjectBehavior;
use PhpSpec\Exception\Example\MatcherException;

use Packagist\Api\Client;
use Packagist\Api\Result\Factory;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client as HttpClient;

class ClientSpec extends ObjectBehavior
{
    function let(HttpClient $client, Factory $factory, Request $request, Response $response)
    {
        $this->beConstructedWith($client, $factory);

        $client->request($request)->willReturn($response);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Packagist\Api\Client');
    }

    function it_search_for_packages(HttpClient $client, Factory $factory, Request $request, Response $response)
    {
        $client->request('GET', 'https://packagist.org/search.json?q=sylius')->shouldBeCalled()->willReturn($response);
        $data = file_get_contents('spec/Packagist/Api/Fixture/search.json');
        $response->getBody()->shouldBeCalled()->willReturn($data);
        $factory->create(json_decode($data, true))->shouldBeCalled()->willReturn(array());

        $this->search('sylius');
    }

    function it_searches_for_packages_with_filters(HttpClient $client, Factory $factory, Request $request, Response $response)
    {
        $client->request('GET', 'https://packagist.org/search.json?tag=storage&q=sylius')->shouldBeCalled()->willReturn($response);
        $data = file_get_contents('spec/Packagist/Api/Fixture/search.json');
        $response->getBody()->shouldBeCalled()->willReturn($data);
        $factory->create(json_decode($data, true))->shouldBeCalled()->willReturn(array());

        $this->search('sylius', array('tag' => 'storage'));
    }

    function it_gets_popular_packages(HttpClient $client, Factory $factory, Request $request, Response $response)
    {
        $client->request('GET', 'https://packagist.org/explore/popular.json?page=1')->shouldBeCalled()->willReturn($response);
        $data = file_get_contents('spec/Packagist/Api/Fixture/popular.json');
        $response->getBody()->shouldBeCalled()->willReturn($data);
        $factory->create(json_decode($data, true))->shouldBeCalled()->willReturn(array_pad(array(), 5, null));

        $this->popular(2)->shouldHaveCount(2);
    }

    function it_gets_package_details(HttpClient $client, Factory $factory, Request $request, Response $response)
    {
        $client->request('GET', 'https://packagist.org/packages/sylius/sylius.json')->shouldBeCalled()->willReturn($response);
        $data = file_get_contents('spec/Packagist/Api/Fixture/get.json');
        $response->getBody()->shouldBeCalled()->willReturn($data);
        $factory->create(json_decode($data, true))->shouldBeCalled();

        $this->get('sylius/sylius');
    }

    function it_lists_all_package_names(HttpClient $client, Factory $factory, Request $request, Response $response)
    {
        $client->request('GET', 'https://packagist.org/packages/list.json')->shouldBeCalled()->willReturn($response);
        $data = file_get_contents('spec/Packagist/Api/Fixture/all.json');
        $response->getBody()->shouldBeCalled()->willReturn($data);
        $factory->create(json_decode($data, true))->shouldBeCalled();

        $this->all();
    }

    function it_filters_package_names_by_type(HttpClient $client, Factory $factory, Request $request, Response $response)
    {
        $client->request('GET', 'https://packagist.org/packages/list.json?type=library')->shouldBeCalled()->willReturn($response);
        $data = file_get_contents('spec/Packagist/Api/Fixture/all.json');
        $response->getBody()->shouldBeCalled()->willReturn($data);
        $factory->create(json_decode($data, true))->shouldBeCalled();

        $this->all(array('type' => 'library'));
    }

    function it_filters_package_names_by_vendor(HttpClient $client, Factory $factory, Request $request, Response $response)
    {
        $client->request('GET', 'https://packagist.org/packages/list.json?vendor=sylius')->shouldBeCalled()->willReturn($response);
        $data = file_get_contents('spec/Packagist/Api/Fixture/all.json');
        $response->getBody()->shouldBeCalled()->willReturn($data);
        $factory->create(json_decode($data, true))->shouldBeCalled();

        $this->all(array('vendor' => 'sylius'));
    }
}
