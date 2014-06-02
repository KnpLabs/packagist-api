<?php

namespace spec\Packagist\Api;

use PhpSpec\ObjectBehavior;
use Packagist\Api\PackagistApiClient;
use Packagist\Api\Result\Factory;
use Guzzle\Http\Message\Request;
use Guzzle\Http\Message\Response;
use Guzzle\Http\Client;
use Packagist\Api\Result\ResultCollection;
use Packagist\Api\Filter;

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

    public function it_search_for_packages(Client $client, Factory $factory, Response $response)
    {
        $client->get('https://packagist.org/search.json?q=sylius')->shouldBeCalled()->willReturn($client);
        $client->send()->shouldBeCalled()->willReturn($response);
        $data = self::load('search.json');
        $response->getBody(true)->shouldBeCalled()->willReturn($data);

        $factory->createSearchResults(new ResultCollection(), json_decode($data, true))->shouldBeCalled()->willReturn(array());

        $this->search('sylius');
    }

    function it_searches_for_packages_with_filters(Client $client, Factory $factory, Request $request, Response $response)
    {
        $client->get('https://packagist.org/search.json?q=sylius&tags[]=storage')->shouldBeCalled()->willReturn($request);
        $data = self::load('search.json');
        $response->getBody(true)->shouldBeCalled()->willReturn($data);
        $factory->createSearchResults(new ResultCollection(), json_decode($data, true))->shouldBeCalled()->willReturn(array());

        $filter = new Filter();
        $filter->addTag('storage');
        $this->search('sylius', $filter);
    }

    function it_gets_package_details(Client $client, Factory $factory, Request $request, Response $response)
    {
        $client->get('https://packagist.org/packages/sylius/sylius.json')->shouldBeCalled()->willReturn($request);
        $data = self::load('get.json');
        $response->getBody(true)->shouldBeCalled()->willReturn($data);
        $factory->createPackageResults(json_decode($data, true))->shouldBeCalled();

        $this->get('sylius/sylius');
    }

    function it_throw_exception_on_respond_null(Client $client, Factory $factory, Request $request, Response $response)
    {
    	$client->get('https://packagist.org/packages/sylius/sylius.json')->shouldBeCalled()->willReturn($request);
    	$response->getBody(true)->shouldBeCalled()->willReturn(null);

    	$this->shouldThrow('Packagist\Api\PackagistApiResponseException')->duringGet('sylius/sylius');
    }

    function it_throw_exception_on_wrong_package(Client $client, Factory $factory, Request $request, Response $response)
    {
    	$client->get('https://packagist.org/packages/mywrongpackage.json')->willThrow('Guzzle\Http\Exception\ClientErrorResponseException');

    	$this->shouldThrow('Packagist\Api\PackagistApiResponseException')->duringGet('mywrongpackage');
    }

    function it_lists_all_package_names(Client $client, Factory $factory, Request $request, Response $response)
    {
        $client->get('https://packagist.org/packages/list.json')->shouldBeCalled()->willReturn($request);
        $data = self::load('all.json');
        $response->getBody(true)->shouldBeCalled()->willReturn($data);
        $factory->createSimpleResults(json_decode($data, true))->shouldBeCalled();

        $this->all();
    }

    function it_filters_package_names_by_type(Client $client, Factory $factory, Request $request, Response $response)
    {
        $client->get('https://packagist.org/packages/list.json?type=library')->shouldBeCalled()->willReturn($request);
        $data = self::load('all.json');
        $response->getBody(true)->shouldBeCalled()->willReturn($data);
        $factory->createSimpleResults(json_decode($data, true))->shouldBeCalled();

        $filter = new Filter();
        $filter->setType('library');
        $this->all($filter);
    }

    function it_filters_package_names_by_vendor(Client $client, Factory $factory, Request $request, Response $response)
    {
        $client->get('https://packagist.org/packages/list.json?vendor=sylius')->shouldBeCalled()->willReturn($request);
        $data = self::load('all.json');
        $response->getBody(true)->shouldBeCalled()->willReturn($data);
        $factory->createSimpleResults(json_decode($data, true))->shouldBeCalled();

        $filter = new Filter();
        $filter->setVendor('sylius');
        $this->all($filter);
    }
}
