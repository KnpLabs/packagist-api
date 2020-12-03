<?php

declare(strict_types=1);

namespace Packagist\Api;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\ClientInterface;
use Packagist\Api\Result\Factory;
use Packagist\Api\Result\Package;
use Psr\Http\Message\StreamInterface;

/**
 * Packagist Api
 *
 * @api
 */
class Client
{
    protected ClientInterface $httpClient;

    protected Factory $resultFactory;

    protected string $packagistUrl;

    /**
     * @param ClientInterface|null $httpClient    HTTP client
     * @param Factory|null         $resultFactory DataObject Factory
     * @param string               $packagistUrl  Packagist URL
     */
    public function __construct(
        ClientInterface $httpClient = null,
        Factory $resultFactory = null,
        string $packagistUrl = 'https://packagist.org'
    ) {
        if (null === $httpClient) {
            $httpClient = new HttpClient();
        }

        if (null === $resultFactory) {
            $resultFactory = new Factory();
        }

        $this->httpClient = $httpClient;
        $this->resultFactory = $resultFactory;
        $this->packagistUrl = $packagistUrl;
    }

    /**
     * Search packages
     *
     * Available filters:
     *
     *    * vendor: vendor of package (require or require-dev in composer.json)
     *    * type:   type of package (type in composer.json)
     *    * tags:   tags of package (keywords in composer.json)
     *
     * @param string $query   Name of package
     * @param array  $filters An array of filters
     * @param int    $limit   Pages to limit results (0 = all pages)
     *
     * @return array The results
     */
    public function search(string $query, array $filters = [], int $limit = 0): array
    {
        $results = $response = [];
        $filters['q'] = $query;
        $url = '/search.json?' . http_build_query($filters);
        $response['next'] = $this->url($url);

        do {
            $response = $this->request($response['next']);
            $response = $this->parse((string) $response);
            $createResult = $this->create($response);
            if (!is_array($createResult)) {
                $createResult = [$createResult];
            }
            $results = array_merge($results, $createResult);
            if (isset($response['next'])) {
                parse_str(parse_url($response['next'], PHP_URL_QUERY), $parse);
            }
        } while (isset($response['next']) && (0 === $limit || $parse['page'] <= $limit));

        return $results;
    }

    /**
     * Retrieves full package details, generated dynamically by the Packagist API.
     * Consider using {@link getComposer()} instead to use the Packagist API
     * more efficiently if you don't need all the full metadata for a package.
     *
     * @param string $package Full qualified name ex : myname/mypackage
     * @return array|Package A package instance or array of packages
     */
    public function get(string $package)
    {
        return $this->respond(sprintf($this->url('/packages/%s.json'), $package));
    }

    /**
     * Similar to {@link get()}, but uses composer metadata which is Packagist's preferred
     * way of retrieving details, since responses are cached efficiently as static files
     * by the Packagist service. The response lacks some metadata that is provided
     * by {@link get()}, see https://packagist.org/apidoc for details.
     *
     * Caution: Returns an array of packages, you need to select the correct one
     * from the indexed array.
     *
     * @since 1.6
     *
     * @param string $package Full qualified name ex : myname/mypackage
     *
     * @return \Packagist\Api\Result\Package[] An array of packages, including the requested one.
     */
    public function getComposer($package)
    {
        return $this->respond(sprintf($this->url('/p/%s.json'), $package));
    }

    /**
     * Search packages
     *
     * Available filters:
     *
     *    * vendor: vendor of package (require or require-dev in composer.json)
     *    * type:   type of package (type in composer.json)
     *    * tags:   tags of package (keywords in composer.json)
     *
     * @param array  $filters An array of filters
     * @return array|Package The results, or single result
     */
    public function all(array $filters = [])
    {
        $url = '/packages/list.json';
        if ($filters) {
            $url .= '?' . http_build_query($filters);
        }

        return $this->respond($this->url($url));
    }

    /**
     * Popular packages
     *
     * @param int $total
     * @return array The results
     */
    public function popular(int $total): array
    {
        $results = $response = array();
        $url = '/explore/popular.json?' . http_build_query(array('page' => 1));
        $response['next'] = $this->url($url);

        do {
            $response = $this->request($response['next']);
            $response = $this->parse((string) $response);
            $createResult = $this->create($response);
            if (!is_array($createResult)) {
                $createResult = [$createResult];
            }
            $results = array_merge($results, $createResult);
        } while (count($results) < $total && isset($response['next']));

        return array_slice($results, 0, $total);
    }

    /**
     * Assemble the packagist URL with the route
     *
     * @param string $route API Route that we want to achieve
     * @return string Fully qualified URL
     */
    protected function url(string $route): string
    {
        return $this->packagistUrl . $route;
    }

    /**
     * Execute the url request and parse the response
     *
     * @param string $url
     * @return array|Package
     */
    protected function respond(string $url)
    {
        $response = $this->request($url);
        $response = $this->parse((string) $response);

        return $this->create($response);
    }

    /**
     * Execute the request URL
     *
     * @param string $url
     * @return string
     */
    protected function request(string $url): string
    {
        return (string) $this->httpClient
            ->request('GET', $url)
            ->getBody();
    }

    /**
     * Decode JSON
     *
     * @param string $data JSON string
     *
     * @return array JSON decode
     */
    protected function parse(string $data): array
    {
        return json_decode($data, true) ?? [];
    }

    /**
     * Hydrate the knowing type depending on passed data
     *
     * @param array $data
     * @return array|Package
     */
    protected function create(array $data)
    {
        return $this->resultFactory->create($data);
    }

    /**
     * Change the packagist URL
     *
     * @param string $packagistUrl URL
     * @return $this
     */
    public function setPackagistUrl(string $packagistUrl): self
    {
        $this->packagistUrl = $packagistUrl;
        return $this;
    }

    /**
     * Return the actual packagist URL
     *
     * @return string URL
     */
    public function getPackagistUrl(): string
    {
        return $this->packagistUrl;
    }
}
