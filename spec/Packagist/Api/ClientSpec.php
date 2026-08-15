<?php

declare(strict_types=1);

namespace spec\Packagist\Api;

use Packagist\Api\Client;
use Packagist\Api\PackageNotFoundException;
use Packagist\Api\Result\Factory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ClientSpec extends ObjectBehavior
{
    public function let(ClientInterface $client, Factory $factory)
    {
        $this->beConstructedWith($client, $factory);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Client::class);
    }

    public function it_search_for_packages(ClientInterface $client, Factory $factory, ResponseInterface $response, StreamInterface $body): void
    {
        $data = file_get_contents('spec/Packagist/Api/Fixture/search.json');
        $response->getStatusCode()->willReturn(200);
        $response->getBody()->willReturn($body);
        $body->getContents()->willReturn($data);

        $client->sendRequest($this->requestMatching('GET', 'https://packagist.org/search.json?q=sylius'))
            ->shouldBeCalled()
            ->willReturn($response);
        $factory->create(json_decode($data, true))->shouldBeCalled()->willReturn([]);

        $this->search('sylius');
    }

    public function it_search_for_packages_with_limit(ClientInterface $client, Factory $factory, ResponseInterface $response, StreamInterface $body): void
    {
        $data = file_get_contents('spec/Packagist/Api/Fixture/search.json');
        $response->getStatusCode()->willReturn(200);
        $response->getBody()->willReturn($body);
        $body->getContents()->willReturn($data);

        $client->sendRequest($this->requestMatching('GET', 'https://packagist.org/search.json?q=sylius'))
            ->shouldBeCalled()
            ->willReturn($response);
        $factory->create(json_decode($data, true))->shouldBeCalled()->willReturn(array());

        $this->search('sylius', [], 2);
    }

    public function it_searches_for_packages_with_filters(ClientInterface $client, Factory $factory, ResponseInterface $response, StreamInterface $body): void
    {
        $data = file_get_contents('spec/Packagist/Api/Fixture/search.json');
        $response->getStatusCode()->willReturn(200);
        $response->getBody()->willReturn($body);
        $body->getContents()->willReturn($data);

        $client->sendRequest($this->requestMatching('GET', 'https://packagist.org/search.json?tag=storage&q=sylius'))
            ->shouldBeCalled()
            ->willReturn($response);
        $factory->create(json_decode($data, true))->shouldBeCalled()->willReturn([]);

        $this->search('sylius', ['tag' => 'storage']);
    }

    public function it_gets_popular_packages(ClientInterface $client, Factory $factory, ResponseInterface $response, StreamInterface $body): void
    {
        $data = file_get_contents('spec/Packagist/Api/Fixture/popular.json');
        $response->getStatusCode()->willReturn(200);
        $response->getBody()->willReturn($body);
        $body->getContents()->willReturn($data);

        $client->sendRequest($this->requestMatching('GET', 'https://packagist.org/explore/popular.json?page=1'))
            ->shouldBeCalled()
            ->willReturn($response);
        $factory->create(json_decode($data, true))
            ->shouldBeCalled()
            ->willReturn(array_pad([], 5, null));

        $this->popular(2)->shouldHaveCount(2);
    }

    public function it_gets_package_details(ClientInterface $client, Factory $factory, ResponseInterface $response, StreamInterface $body): void
    {
        $data = file_get_contents('spec/Packagist/Api/Fixture/get.json');
        $response->getStatusCode()->willReturn(200);
        $response->getBody()->willReturn($body);
        $body->getContents()->willReturn($data);

        $client->sendRequest($this->requestMatching('GET', 'https://packagist.org/packages/sylius/sylius.json'))
            ->shouldBeCalled()
            ->willReturn($response);
        $factory->create(json_decode($data, true))->shouldBeCalled();

        $this->get('sylius/sylius');
    }

    public function it_gets_composer_package_details(ClientInterface $client, Factory $factory, ResponseInterface $response, StreamInterface $body): void
    {
        $data1 = file_get_contents('spec/Packagist/Api/Fixture/v2_get.json');
        $data2 = file_get_contents('spec/Packagist/Api/Fixture/v2_get_dev.json');
        $response->getStatusCode()->willReturn(200);
        $response->getBody()->willReturn($body);
        $body->getContents()->willReturn($data1, $data2);

        $client->sendRequest($this->requestMatching('GET', 'https://repo.packagist.org/p2/sylius/sylius.json'))
            ->shouldBeCalled()
            ->willReturn($response);

        $client->sendRequest($this->requestMatching('GET', 'https://repo.packagist.org/p2/sylius/sylius~dev.json'))
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

    public function it_gets_composer_releases_package_details(ClientInterface $client, Factory $factory, ResponseInterface $response, StreamInterface $body): void
    {
        $data = file_get_contents('spec/Packagist/Api/Fixture/v2_get.json');
        $response->getStatusCode()->willReturn(200);
        $response->getBody()->willReturn($body);
        $body->getContents()->willReturn($data);

        $client->sendRequest($this->requestMatching('GET', 'https://repo.packagist.org/p2/sylius/sylius.json'))
            ->shouldBeCalled()
            ->willReturn($response);

        $packages = [
            '1.0.0' => ['name' => 'sylius/sylius', 'version' => '1.0.0']
        ];

        $factory->create(json_decode($data, true))->shouldBeCalled()->willReturn($packages);

        $this->getComposerReleases('sylius/sylius')->shouldBe($packages);
    }

    public function it_lists_all_package_names(ClientInterface $client, Factory $factory, ResponseInterface $response, StreamInterface $body): void
    {
        $data = file_get_contents('spec/Packagist/Api/Fixture/all.json');
        $response->getStatusCode()->willReturn(200);
        $response->getBody()->willReturn($body);
        $body->getContents()->willReturn($data);

        $client->sendRequest($this->requestMatching('GET', 'https://packagist.org/packages/list.json'))
            ->shouldBeCalled()
            ->willReturn($response);
        $factory->create(json_decode($data, true))->shouldBeCalled();

        $this->all();
    }

    public function it_filters_package_names_by_type(ClientInterface $client, Factory $factory, ResponseInterface $response, StreamInterface $body): void
    {
        $data = file_get_contents('spec/Packagist/Api/Fixture/all.json');
        $response->getStatusCode()->willReturn(200);
        $response->getBody()->willReturn($body);
        $body->getContents()->willReturn($data);

        $client->sendRequest($this->requestMatching('GET', 'https://packagist.org/packages/list.json?type=library'))
            ->shouldBeCalled()
            ->willReturn($response);
        $factory->create(json_decode($data, true))->shouldBeCalled();

        $this->all(['type' => 'library']);
    }

    public function it_filters_package_names_by_vendor(ClientInterface $client, Factory $factory, ResponseInterface $response, StreamInterface $body): void
    {
        $data = file_get_contents('spec/Packagist/Api/Fixture/all.json');
        $response->getStatusCode()->willReturn(200);
        $response->getBody()->willReturn($body);
        $body->getContents()->willReturn($data);

        $client->sendRequest($this->requestMatching('GET', 'https://packagist.org/packages/list.json?vendor=sylius'))
            ->shouldBeCalled()
            ->willReturn($response);
        $factory->create(json_decode($data, true))->shouldBeCalled();

        $this->all(['vendor' => 'sylius']);
    }

    public function it_throws_exception_on_404s(ClientInterface $client, ResponseInterface $response): void
    {
        $response->getStatusCode()->willReturn(404);

        $client->sendRequest($this->requestMatching('GET', 'https://packagist.org/packages/i-do/not-exist.json'))
            ->shouldBeCalled()
            ->willReturn($response);

        $this->shouldThrow(PackageNotFoundException::class)
            ->during('get', ['i-do/not-exist']);
    }

    /**
     * Builds a Prophecy argument matcher that asserts a PSR-7 request was built
     * for the given HTTP method and fully qualified URL.
     */
    private function requestMatching(string $method, string $url): Argument\Token\TokenInterface
    {
        return Argument::that(function (RequestInterface $request) use ($method, $url): bool {
            return $request->getMethod() === $method && (string) $request->getUri() === $url;
        });
    }
}
