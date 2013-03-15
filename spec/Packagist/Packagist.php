<?php

namespace spec\Packagist;

use PHPSpec2\ObjectBehavior;
use spec\Packagist\Fixture\FixtureLoader;

class Packagist extends ObjectBehavior
{
    /**
     * @param spec\Packagist\Mock\ClientMock $client
     * @param Guzzle\Http\Message\Request    $request
     * @param Guzzle\Http\Message\Response   $response
     */
    function let($client, $request, $response)
    {
        $this->beConstructedWith($client);

        $request->send()->willReturn($response);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Packagist\Packagist');
    }

    function it_search_for_packages($client, $request, $response)
    {
        $client->get('https://packagist.org/search.json?q=sylius')->shouldBeCalled()->willReturn($request);

        $response->getBody(true)->shouldBeCalled()->willReturn(
            FixtureLoader::load('search.json')
        );

        $this->search('sylius')->shouldHaveCount(15);
    }

    function it_gets_package_details($client, $request, $response)
    {
        $client->get('https://packagist.org/p/sylius/sylius.json')->shouldBeCalled()->willReturn($request);
        $response->getBody(true)->shouldBeCalled()->willReturn(
            FixtureLoader::load('get.json')
        );

        $this->get('sylius/sylius')->shouldHaveCount(2);
    }
}
