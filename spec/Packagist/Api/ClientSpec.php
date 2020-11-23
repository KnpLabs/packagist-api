<?php

declare(strict_types=1);

namespace spec\Packagist\Api;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7\Response;
use Packagist\Api\Client;
use Packagist\Api\Result\Factory;
use PhpSpec\ObjectBehavior;

class ClientSpec extends ObjectBehavior
{
    public function let(HttpClient $client, Factory $factory)
    {
        $this->beConstructedWith($client, $factory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Client::class);
    }

    public function it_search_for_packages(HttpClient $client, Factory $factory, Response $response)
    {
        $data = file_get_contents('spec/Packagist/Api/Fixture/search.json');
        $response->getBody()->shouldBeCalled()->willReturn($data);

        $client->request('get', 'https://packagist.org/search.json?q=sylius')
			->shouldBeCalled()
			->willReturn($response);
        $factory->create(json_decode($data, true))->shouldBeCalled()->willReturn([]);

        $this->search('sylius');
    }

    public function it_searches_for_packages_with_filters(HttpClient $client, Factory $factory, Response $response)
    {
        $data = file_get_contents('spec/Packagist/Api/Fixture/search.json');
        $response->getBody()->shouldBeCalled()->willReturn($data);

        $client->request('get', 'https://packagist.org/search.json?tag=storage&q=sylius')
			->shouldBeCalled()
			->willReturn($response);

        $factory->create(json_decode($data, true))->shouldBeCalled()->willReturn([]);

        $this->search('sylius', ['tag' => 'storage']);
    }

    public function it_gets_popular_packages(HttpClient $client, Factory $factory, Response $response)
    {
        $data = file_get_contents('spec/Packagist/Api/Fixture/popular.json');
        $response->getBody()->shouldBeCalled()->willReturn($data);

        $client->request('get', 'https://packagist.org/explore/popular.json?page=1')
			->shouldBeCalled()
			->willReturn($response);

        $factory->create(json_decode($data, true))
			->shouldBeCalled()
			->willReturn(array_pad([], 5, null));

        $this->popular(2)->shouldHaveCount(2);
    }

    public function it_gets_package_details(HttpClient $client, Factory $factory, Response $response)
    {
        $data = file_get_contents('spec/Packagist/Api/Fixture/get.json');
        $response->getBody()->shouldBeCalled()->willReturn($data);

        $client->request('get', 'https://packagist.org/packages/sylius/sylius.json')
			->shouldBeCalled()
			->willReturn($response);

        $factory->create(json_decode($data, true))->shouldBeCalled();

        $this->get('sylius/sylius');
    }

    public function it_gets_composer_package_details(HttpClient $client, Factory $factory, Response $response)
    {
        $data = file_get_contents('spec/Packagist/Api/Fixture/get_composer.json');
        $response->getBody()->shouldBeCalled()->willReturn($data);

        $client->request('get', 'https://packagist.org/p/sylius/sylius.json')->shouldBeCalled()->willReturn($response);

        $factory->create(json_decode($data, true))->shouldBeCalled();

        $this->getComposer('sylius/sylius');
    }

    public function it_lists_all_package_names(HttpClient $client, Factory $factory, Response $response)
    {
        $data = file_get_contents('spec/Packagist/Api/Fixture/all.json');
        $response->getBody()->shouldBeCalled()->willReturn($data);

        $client->request('get', 'https://packagist.org/packages/list.json')
			->shouldBeCalled()
			->willReturn($response);

        $factory->create(json_decode($data, true))->shouldBeCalled();

        $this->all();
    }

    public function it_filters_package_names_by_type(HttpClient $client, Factory $factory, Response $response)
    {
        $data = file_get_contents('spec/Packagist/Api/Fixture/all.json');
        $response->getBody()->shouldBeCalled()->willReturn($data);

        $client->request('get', 'https://packagist.org/packages/list.json?type=library')
			->shouldBeCalled()
			->willReturn($response);

        $factory->create(json_decode($data, true))->shouldBeCalled();

        $this->all(['type' => 'library']);
    }

    public function it_filters_package_names_by_vendor(HttpClient $client, Factory $factory, Response $response)
    {
        $data = file_get_contents('spec/Packagist/Api/Fixture/all.json');
        $response->getBody()->shouldBeCalled()->willReturn($data);

        $client->request('get', 'https://packagist.org/packages/list.json?vendor=sylius')
			->shouldBeCalled()
			->willReturn($response);

        $factory->create(json_decode($data, true))->shouldBeCalled();

        $this->all(['vendor' => 'sylius']);
    }
}
