<?php

declare(strict_types=1);

namespace spec\Packagist\Api;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use Packagist\Api\Client;
use Packagist\Api\Result\Factory;
use PhpSpec\ObjectBehavior;

class ClientSpec extends ObjectBehavior
{
    public function let(HttpClient $client, Factory $factory)
    {
        $this->beConstructedWith($client, $factory);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Client::class);
    }

    public function it_search_for_packages(HttpClient $client, Factory $factory, Response $response, Stream $body): void
    {
        $data = file_get_contents('spec/Packagist/Api/Fixture/search.json');
        $response->getBody()->shouldBeCalled()->willReturn($body);
        $body->getContents()->shouldBeCalled()->willReturn($data);

        $client->request('GET', 'https://packagist.org/search.json?q=sylius')
			->shouldBeCalled()
			->willReturn($response);
        $factory->create(json_decode($data, true))->shouldBeCalled()->willReturn([]);

        $this->search('sylius');
    }

    public function it_search_for_packages_with_limit(HttpClient $client, Factory $factory, Response $response, Stream $body): void
    {
        $data = file_get_contents('spec/Packagist/Api/Fixture/search.json');
        $response->getBody()->shouldBeCalled()->willReturn($body);
        $body->getContents()->shouldBeCalled()->willReturn($data);

        $client->request('GET', 'https://packagist.org/search.json?q=sylius')->shouldBeCalled()->willReturn($response);
        $factory->create(json_decode($data, true))->shouldBeCalled()->willReturn(array());

        $this->search('sylius', [], 2);
    }

    public function it_searches_for_packages_with_filters(HttpClient $client, Factory $factory, Response $response, Stream $body): void
    {
        $data = file_get_contents('spec/Packagist/Api/Fixture/search.json');
        $response->getBody()->shouldBeCalled()->willReturn($body);
        $body->getContents()->shouldBeCalled()->willReturn($data);

        $client->request('GET', 'https://packagist.org/search.json?tag=storage&q=sylius')
			->shouldBeCalled()
			->willReturn($response);

        $factory->create(json_decode($data, true))->shouldBeCalled()->willReturn([]);

        $this->search('sylius', ['tag' => 'storage']);
    }

    public function it_gets_popular_packages(HttpClient $client, Factory $factory, Response $response, Stream $body): void
    {
        $data = file_get_contents('spec/Packagist/Api/Fixture/popular.json');
        $response->getBody()->shouldBeCalled()->willReturn($body);
        $body->getContents()->shouldBeCalled()->willReturn($data);

        $client->request('GET', 'https://packagist.org/explore/popular.json?page=1')
			->shouldBeCalled()
			->willReturn($response);

        $factory->create(json_decode($data, true))
			->shouldBeCalled()
			->willReturn(array_pad([], 5, null));

        $this->popular(2)->shouldHaveCount(2);
    }

    public function it_gets_package_details(HttpClient $client, Factory $factory, Response $response, Stream $body): void
    {
        $data = file_get_contents('spec/Packagist/Api/Fixture/get.json');
        $response->getBody()->shouldBeCalled()->willReturn($body);
        $body->getContents()->shouldBeCalled()->willReturn($data);

        $client->request('GET', 'https://packagist.org/packages/sylius/sylius.json')
			->shouldBeCalled()
			->willReturn($response);

        $factory->create(json_decode($data, true))->shouldBeCalled();

        $this->get('sylius/sylius');
    }

    public function it_gets_composer_package_details(HttpClient $client, Factory $factory, Response $response, Stream $body): void
    {
        $data1 = file_get_contents('spec/Packagist/Api/Fixture/v2_get.json');
        $data2 = file_get_contents('spec/Packagist/Api/Fixture/v2_get_dev.json');
        $response->getBody()->shouldBeCalled()->willReturn($body);
        $body->getContents()->shouldBeCalledTimes(2)->willReturn($data1, $data2);

        $client->request('GET', 'https://packagist.org/p2/sylius/sylius.json')
            ->shouldBeCalled()
            ->willReturn($response);

        $client->request('GET', 'https://packagist.org/p2/sylius/sylius~dev.json')
            ->shouldBeCalled()
            ->willReturn($response);

        $data1 = json_decode($data1, true);
        $data2 = json_decode($data2, true);
        $factoryInput = $data1;
        $factoryInput['packages']['sylius/sylius'] = [
            ...$data1['packages']['sylius/sylius'],
            ...$data2['packages']['sylius/sylius'],
        ];

        $factory->create($factoryInput)->shouldBeCalled()->willReturn([
            'packages' => [
                'sylius/sylius' => [
                    ['name' => 'sylius/sylius', 'version' => '1.0.0'],
                    ['name' => 'sylius/sylius', 'version' => 'dev-master'],
                ],
            ],
        ]);

        $this->getComposer('sylius/sylius');
    }

    public function it_gets_composer_releases_package_details(HttpClient $client, Factory $factory, Response $response, Stream $body): void
    {
        $data = file_get_contents('spec/Packagist/Api/Fixture/v2_get.json');
        $response->getBody()->shouldBeCalled()->willReturn($body);
        $body->getContents()->shouldBeCalled()->willReturn($data);

        $client->request('GET', 'https://packagist.org/p2/sylius/sylius.json')
            ->shouldBeCalled()
            ->willReturn($response);

        $packages = [
            '1.0.0' => ['name' => 'sylius/sylius', 'version' => '1.0.0']
        ];

        $factory->create(json_decode($data, true))->shouldBeCalled()->willReturn($packages);

        $this->getComposerReleases('sylius/sylius')->shouldBe($packages);
    }

    public function it_lists_all_package_names(HttpClient $client, Factory $factory, Response $response, Stream $body): void
    {
        $data = file_get_contents('spec/Packagist/Api/Fixture/all.json');
        $response->getBody()->shouldBeCalled()->willReturn($body);
        $body->getContents()->shouldBeCalled()->willReturn($data);

        $client->request('GET', 'https://packagist.org/packages/list.json')
			->shouldBeCalled()
			->willReturn($response);

        $factory->create(json_decode($data, true))->shouldBeCalled();

        $this->all();
    }

    public function it_filters_package_names_by_type(HttpClient $client, Factory $factory, Response $response, Stream $body): void
    {
        $data = file_get_contents('spec/Packagist/Api/Fixture/all.json');
        $response->getBody()->shouldBeCalled()->willReturn($body);
        $body->getContents()->shouldBeCalled()->willReturn($data);

        $client->request('GET', 'https://packagist.org/packages/list.json?type=library')
			->shouldBeCalled()
			->willReturn($response);

        $factory->create(json_decode($data, true))->shouldBeCalled();

        $this->all(['type' => 'library']);
    }

    public function it_filters_package_names_by_vendor(HttpClient $client, Factory $factory, Response $response, Stream $body): void
    {
        $data = file_get_contents('spec/Packagist/Api/Fixture/all.json');
        $response->getBody()->shouldBeCalled()->willReturn($body);
        $body->getContents()->shouldBeCalled()->willReturn($data);

        $client->request('GET', 'https://packagist.org/packages/list.json?vendor=sylius')
			->shouldBeCalled()
			->willReturn($response);

        $factory->create(json_decode($data, true))->shouldBeCalled();

        $this->all(['vendor' => 'sylius']);
    }

}
