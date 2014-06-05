<?php

namespace Packagist\Api;

use Guzzle\Http\Client as HttpClient;
use Guzzle\Http\ClientInterface;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Packagist\Api\Result\Factory;
use Packagist\Api\Result\ResultCollection;

class Client
{
    /**
     * @var ClientInterface
     */
    private $httpClient = null;
    /**
     * @var Factory
     */
    private $resultFactory = null;
    /**
     * @var string
     */
    private $packagistUrl = null;

    /**
     * @param ClientInterface $httpClient
     * @param Factory         $resultFactory
     * @param string          $packagistUrl
     */
    public function __construct(
        ClientInterface $httpClient = null,
        Factory $resultFactory = null,
        $packagistUrl = "https://packagist.org"
    )
    {
        $this->httpClient = ($httpClient === null) ? new HttpClient() : $httpClient;
        $this->resultFactory = ($resultFactory === null) ? new Factory() : $resultFactory;
        $this->packagistUrl = $packagistUrl;
    }

    /**
     * @param string      $query
     * @param null|Filter $filter
     *
     * @return \Packagist\Api\Result\ResultCollection
     */
    public function search($query, Filter $filter = null)
    {
        $filter           = (($filter === null) ? '' : '&' . $filter->getHttpQuery());
        $url              = '/search.json?q=' . urlencode($query) . $filter;
        $response         = array();
        $response['next'] = $url;
        $resultCollection = new ResultCollection();

        do {
            $response = $this->parseRequestResponse($this->request($response['next']));
            $resultCollection = $this->resultFactory->createSearchResults($resultCollection, $response);
        } while (isset($response['next']));

        return $resultCollection;
    }


    /**
     * Retrieve full package informations by full qualified name ex : myname/mypackage
     *
     * @param string $packageName
     *
     * @throws PackageDoesNotExistException
     * @return \Packagist\Api\Result\Package
     */
    public function get($packageName)
    {
        try {
            $response = $this->parseRequestResponse(
                $this->request(
                    sprintf('/packages/%s.json', $packageName)
                )
            );
        } catch (ClientErrorResponseException $e) {
            throw ResponseException::packageDoesNotExist($packageName);
        }

        if ($response === null) {
            throw ResponseException::packageDoesNotExist($packageName);
        }

        return $this->resultFactory->createPackageResults($response);
    }

    /**
     * @param null|Filter $filter
     *
     * @return array
     */
    public function all(Filter $filter = null)
    {
        $url = '/packages/list.json' . (($filter === null) ? '' : '?' . $filter->getHttpQuery());

        return $this->resultFactory->createSimpleResults(
            $this->parseRequestResponse($this->request($url))
        );
    }

    /**
     * @param string $url
     *
     * @return string
     */
    private function request($url)
    {
        return $this->httpClient->get((strpos($url, 'http') === false) ? $this->packagistUrl . $url : $url)
                                ->send()
                                ->getBody(true);
    }

    /**
     * @param string $response
     *
     * @return array
     */
    private function parseRequestResponse($response)
    {
        return json_decode($response, true);
    }
}
