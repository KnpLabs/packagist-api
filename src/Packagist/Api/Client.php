<?php

declare(strict_types=1);

namespace Packagist\Api;

use Composer\Semver\Semver;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Packagist\Api\Result\Advisory;
use Packagist\Api\Result\Factory;
use Packagist\Api\Result\Package;

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
     * @param string $query Name of package
     * @param array $filters An array of filters
     * @param int $limit Pages to limit results (0 = all pages)
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
     * Similar to {@link get()}, but uses Composer metadata which is Packagist's preferred
     * way of retrieving details, since responses are cached efficiently as static files
     * by the Packagist service. The response lacks some metadata that is provided
     * by {@link get()}, see https://packagist.org/apidoc for details.
     *
     * Caution: Returns an array of packages, you need to select the correct one
     * from the indexed array.
     *
     * @since 1.6
     * @param string $package Full qualified name ex : myname/mypackage
     * @return array An array of packages, including the requested one, containing releases and dev branch versions
     */
    public function getComposer(string $package): array
    {
        return $this->multiRespond(
            sprintf($this->url('/p2/%s.json'), $package),
            sprintf($this->url('/p2/%s~dev.json'), $package)
        );
    }

    /**
     * @see https://packagist.org/apidoc#get-package-data
     * Contains only tagged releases
     * @param string $package Full qualified name ex : myname/mypackage
     * @return Package[] An array of packages, including the requested one.
     */
    public function getComposerReleases(string $package): array
    {
        return $this->respond(sprintf($this->url('/p2/%s.json'), $package));
    }

    /**
     * @see https://packagist.org/apidoc#get-package-data
     * Contains only dev branches
     * @param string $package Full qualified name ex : myname/mypackage
     * @return Package[] An array of packages, including the requested one.
     */
    public function getComposerBranches(string $package): array
    {
        return $this->respond(sprintf($this->url('/p2/%s~dev.json'), $package));
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
     * Get a list of known security vulnerability advisories
     *
     * $packages can be a simple array of package names, or an array with package names
     * as keys and version strings as values.
     *
     * If $filterByVersion is true, any packages which are not accompanied by a version
     * number will be ignored.
     *
     * @param array $packages
     * @param integer|null $updatedSince A unix timestamp.
     * Only advisories updated after this date/time will be included
     * @param boolean $filterByVersion If true, only advisories which affect the version of packages in the
     * $packages array will be included
     * @return Advisory[]
     */
    public function advisories(array $packages = [], ?int $updatedSince = null, bool $filterByVersion = false): array
    {
        if (count($packages) === 0 && $updatedSince === null) {
            throw new \InvalidArgumentException(
                'At least one package or an $updatedSince timestamp must be passed in.'
            );
        }

        if (count($packages) === 0 && $filterByVersion) {
            return [];
        }

        // Add updatedSince to query if passed in
        $query = [];
        if ($updatedSince !== null) {
            $query['updatedSince'] = $updatedSince;
        }
        $options = [
            'query' => array_filter($query),
        ];

        // Add packages if appropriate
        if (count($packages) > 0) {
            $content = ['packages' => []];
            foreach ($packages as $package => $version) {
                if (is_numeric($package)) {
                    $package = $version;
                }
                $content['packages'][] = $package;
            }
            $options['headers']['Content-type'] = 'application/x-www-form-urlencoded';
            $options['body'] = http_build_query($content);
        }

        // Get advisories from API
        /** @var Advisory[] $advisories */
        $advisories = $this->respondPost($this->url('/api/security-advisories/'), $options);

        // Filter advisories if necessary
        if (count($advisories) > 0 && $filterByVersion) {
            return $this->filterAdvisories($advisories, $packages);
        }

        return $advisories;
    }

    /**
     * Filter the advisories array to only include any advisories that affect
     * the versions of packages in the $packages array
     *
     * @param Advisory[] $advisories
     * @param array $packages
     * @return Advisory[] Filtered advisories array
     */
    private function filterAdvisories(array $advisories, array $packages): array
    {
        $filteredAdvisories = [];
        foreach ($packages as $package => $version) {
            // Skip any packages with no declared versions
            if (is_numeric($package)) {
                continue;
            }
            // Filter advisories by version
            if (array_key_exists($package, $advisories)) {
                foreach ($advisories[$package] as $advisory) {
                    if (Semver::satisfies($version, $advisory->getAffectedVersions())) {
                        $filteredAdvisories[$package][] = $advisory;
                    }
                }
            }
        }
        return $filteredAdvisories;
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
     * Execute the POST request and parse the response
     *
     * @param string $url
     * @param array $option
     * @return array|Package
     */
    protected function respondPost(string $url, array $options)
    {
        $response = $this->postRequest($url, $options);
        $response = $this->parse($response);

        return $this->create($response);
    }

    /**
     * Execute two URLs request, parse and merge the responses by adding the versions from the second URL
     * into the versions from the first URL.
     *
     * @param string $url1
     * @param string $url2
     * @return array|Package
     */
    protected function multiRespond(string $url1, string $url2)
    {
        $response1 = $this->request($url1);
        $response1 = $this->parse((string) $response1);

        $response2 = $this->request($url2);
        $response2 = $this->parse((string) $response2);

        foreach ($response1['packages'] as $name => $package1) {
            if (empty($response2['packages'][$name])) {
                continue;
            }
            $response1['packages'][$name] = [
                ...$response1['packages'][$name],
                ...$response2['packages'][$name],
            ];
        }

        return $this->create($response1);
    }

    /**
     * Execute the POST request
     *
     * @param string $url
     * @param array $options
     * @return string
     * @throws GuzzleException
     */
    protected function postRequest(string $url, array $options): string
    {
        return $this->httpClient
            ->request('POST', $url, $options)
            ->getBody()
            ->getContents();
    }

    /**
     * Execute the request URL
     *
     * @param string $url
     * @return string
     * @throws PackageNotFoundException
     * @throws GuzzleException
     */
    protected function request(string $url): string
    {
        try {
            return $this->httpClient
                ->request('GET', $url)
                ->getBody()
                ->getContents();
        } catch (GuzzleException $e) {
            if ($e->getCode() === 404) {
                throw new PackageNotFoundException('The requested package was not found.', 404);
            }
            throw $e;
        }
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
