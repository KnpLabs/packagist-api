<?php

namespace Packagist\Api;

use Guzzle\Http\Client as HttpClient;
use Guzzle\Http\ClientInterface;
use Packagist\Api\Result\Factory;

/**
 * Packagist Api
 *
 * @since 1.0
 * @api
 */
class Client
{
    /**
     * HTTP client
     *
     * @var ClientInterface
     */
    protected $httpClient;

    /**
     * DataObject Factory
     *
     * @var Factory
     */
    protected $resultFactory;

    /**
     * Packagist url
     *
     * @var string
     */
    protected $packagistUrl;

    /**
     * Constructor.
     *
     * @since 1.1 Added the $packagistUrl argument
     * @since 1.0
     *
     * @param ClientInterface|null $httpClient    HTTP client
     * @param Factory|null         $resultFactory DataObject Factory
     * @param string|null          $packagistUrl  Packagist url
     */
    public function __construct(ClientInterface $httpClient = null, Factory $resultFactory = null, $packagistUrl = "https://packagist.org")
    {
        $this->httpClient = $httpClient;
        $this->resultFactory = $resultFactory;
        $this->packagistUrl = $packagistUrl;
    }

    /**
     * Search packages
     *
     * Available filters :
     *
     *    * vendor: vendor of package (require or require-dev in composer.json)
     *    * type:   type of package (type in composer.json)
     *    * tags:   tags of package (keywords in composer.json)
     *
     * @since 1.0
     *
     * @param string $query   Name of package
     * @param array  $filters An array of filters
     *
     * @return array The results
     */
    public function search($query, array $filters = array())
    {
        $results = $response = array();
        $filters['q'] = $query;
        $url = '/search.json?' . http_build_query($filters);
        $response['next'] = $this->url($url);

        do {
            $response = $this->request($response['next']);
            $response = $this->parse($response);
            $results = array_merge($results, $this->create($response));
        } while (isset($response['next']));

        return $results;
    }

    /**
     * Retrieve full package informations
     *
     * @since 1.0
     *
     * @param string $package Full qualified name ex : myname/mypackage
     *
     * @return \Packagist\Api\Result\Package A package instance
     */
    public function get($package)
    {
        return $this->respond(sprintf($this->url('/packages/%s.json'), $package));
    }

    /**
     * Search packages
     *
     * Available filters :
     *
     *    * vendor: vendor of package (require or require-dev in composer.json)
     *    * type:   type of package (type in composer.json)
     *    * tags:   tags of package (keywords in composer.json)
     *
     * @since 1.0
     *
     * @param array  $filters An array of filters
     *
     * @return array The results
     */
    public function all(array $filters = array())
    {
        $url = '/packages/list.json';
        if ($filters) {
            $url .= '?'.http_build_query($filters);
        }

        return $this->respond($this->url($url));
    }

    /**
     * Popular packages
     *
     * @since 1.3
     *
     * @param $total
     * @return array The results
     */
    public function popular($total)
    {
        $results = $response = array();
        $url = '/explore/popular.json?' . http_build_query(array('page' => 1));
        $response['next'] = $this->url($url);

        do {
            $response = $this->request($response['next']);
            $response = $this->parse($response);
            $results = array_merge($results, $this->create($response));
        } while (count($results) < $total && isset($response['next']));

        return array_slice($results, 0, $total);
    }

    /**
     * Assemble the packagist URL with the route
     *
     * @param string $route API Route that we want to achieve
     *
     * @return string Fully qualified URL
     */
    protected function url($route)
    {
        return $this->packagistUrl.$route;
    }

    /**
     * Execute the url request and parse the response
     *
     * @param string $url
     *
     * @return array|\Packagist\Api\Result\Package
     */
    protected function respond($url)
    {
        $response = $this->request($url);
        $response = $this->parse($response);

        return $this->create($response);
    }

    /**
     * Execute the url request
     *
     * @param string $url
     *
     * @return \Guzzle\Http\EntityBodyInterface|string
     */
    protected function request($url)
    {
        if (null === $this->httpClient) {
            $this->httpClient = new HttpClient();
        }

        return $this->httpClient
            ->get($url)
            ->send()
            ->getBody(true)
        ;
    }

    /**
     * Decode json
     *
     * @param string $data Json string
     *
     * @return array Json decode
     */
    protected function parse($data)
    {
        return json_decode($data, true);
    }

    /**
     * Hydrate the knowing type depending on passed data
     *
     * @param array $data
     *
     * @return array|Packagist\Api\Result\Package
     */
    protected function create(array $data)
    {
        if (null === $this->resultFactory) {
            $this->resultFactory = new Factory();
        }

        return $this->resultFactory->create($data);
    }

    /**
     * Change the packagist URL
     *
     * @since 1.1
     *
     * @param string $packagistUrl URL
     */
    public function setPackagistUrl($packagistUrl)
    {
        $this->packagistUrl = $packagistUrl;
    }

    /**
     * Return the actual packagist URL
     *
     * @since 1.1
     *
     * @return string URL
     */
    public function getPackagistUrl()
    {
        return $this->packagistUrl;
    }
}
