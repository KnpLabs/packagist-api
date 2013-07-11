<?php

namespace spec\Packagist\Api;

use PHPSpec2\ObjectBehavior;
use PHPSpec2\Exception\Example\MatcherException;
use Mockery\Matcher\Type as TypeMatcher;
use spec\Packagist\Api\Fixture\FixtureLoader;

class Client extends ObjectBehavior
{
    /**
     * @param spec\Packagist\Api\Mock\ClientMock $client
     * @param Packagist\Api\Result\Factory       $factory
     * @param Guzzle\Http\Message\Request    $request
     * @param Guzzle\Http\Message\Response   $response
     */
    function let($client, $factory, $request, $response)
    {
        $this->beConstructedWith($client, $factory);

        $request->send()->willReturn($response);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Packagist\Api\Client');
    }

    function it_search_for_packages($client, $factory, $request, $response)
    {
        $client->get('https://packagist.org/search.json?q=sylius')->shouldBeCalled()->willReturn($request);
        $data = FixtureLoader::load('search.json');
        $response->getBody(true)->shouldBeCalled()->willReturn($data);
        $factory->create(json_decode($data, true))->shouldBeCalled()->willReturn(array());

        $this->search('sylius');
    }

    function it_searches_for_packages_with_filters($client, $factory, $request, $response)
    {
        $client->get('https://packagist.org/search.json?tag=storage&q=sylius')->shouldBeCalled()->willReturn($request);
        $data = FixtureLoader::load('search.json');
        $response->getBody(true)->shouldBeCalled()->willReturn($data);
        $factory->create(json_decode($data, true))->shouldBeCalled()->willReturn(array());

        $this->search('sylius', array('tag' => 'storage'));
    }

    function it_gets_package_details($client, $factory, $request, $response)
    {
        $client->get('https://packagist.org/packages/sylius/sylius.json')->shouldBeCalled()->willReturn($request);
        $data = FixtureLoader::load('get.json');
        $response->getBody(true)->shouldBeCalled()->willReturn($data);
        $factory->create(json_decode($data, true))->shouldBeCalled();

        $this->get('sylius/sylius');
    }

    function it_lists_all_package_names($client, $factory, $request, $response)
    {
        $client->get('https://packagist.org/packages/list.json')->shouldBeCalled()->willReturn($request);
        $data = FixtureLoader::load('all.json');
        $response->getBody(true)->shouldBeCalled()->willReturn($data);
        $factory->create(json_decode($data, true))->shouldBeCalled();

        $this->all();
    }

    function it_filters_package_names_by_type($client, $factory, $request, $response)
    {
        $client->get('https://packagist.org/packages/list.json?type=library')->shouldBeCalled()->willReturn($request);
        $data = FixtureLoader::load('all.json');
        $response->getBody(true)->shouldBeCalled()->willReturn($data);
        $factory->create(json_decode($data, true))->shouldBeCalled();

        $this->all(array('type' => 'library'));
    }

    function it_filters_package_names_by_vendor($client, $factory, $request, $response)
    {
        $client->get('https://packagist.org/packages/list.json?vendor=sylius')->shouldBeCalled()->willReturn($request);
        $data = FixtureLoader::load('all.json');
        $response->getBody(true)->shouldBeCalled()->willReturn($data);
        $factory->create(json_decode($data, true))->shouldBeCalled();

        $this->all(array('vendor' => 'sylius'));
    }
}
