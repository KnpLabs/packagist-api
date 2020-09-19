<?php

declare(strict_types=1);

namespace Packagist\Api\Result;

use InvalidArgumentException;
use Packagist\Api\Result\Package\Author;
use Packagist\Api\Result\Package\Dist;
use Packagist\Api\Result\Package\Downloads;
use Packagist\Api\Result\Package\Maintainer;
use Packagist\Api\Result\Package\Source;
use Packagist\Api\Result\Package\Version;

/**
 * Map raw data from website api to has a know type
 *
 * @since 1.0
 */
class Factory
{
    /**
     * Analyse the data and transform to a known type
     *
     * @param array $data
     * @throws InvalidArgumentException
     *
     * @return array|Package
     */
    public function create(array $data)
    {
        if (isset($data['results'])) {
            return $this->createSearchResults($data['results']);
        }
        if (isset($data['packages'])) {
            return $this->createSearchResults($data['packages']);
        }
        if (isset($data['package'])) {
            return $this->createPackageResults($data['package']);
        }
        if (isset($data['packageNames'])) {
            return $data['packageNames'];
        }

        throw new InvalidArgumentException('Invalid input data.');
    }

    /**
     * Create a collection of \Packagist\Api\Result\Result
     *
     * @param array $results
     * @return array
     */
    public function createSearchResults(array $results): array
    {
        $created = [];
        foreach ($results as $key => $result) {
            $created[$key] = $this->createResult(Result::class, $result);
        }
        return $created;
    }

    /**
     * Parse array to \Packagist\Api\Result\Result
     *
     * @param array $package
     * @return Package
     */
    public function createPackageResults(array $package): Package
    {
        if (isset($package['maintainers']) && $package['maintainers']) {
            foreach ($package['maintainers'] as $key => $maintainer) {
                $package['maintainers'][$key] = $this->createResult(Maintainer::class, $maintainer);
            }
        }

        if (isset($package['downloads']) && $package['downloads']) {
            $package['downloads'] = $this->createResult(Downloads::class, $package['downloads']);
        }

        foreach ($package['versions'] as $branch => $version) {
            if (isset($version['authors']) && $version['authors']) {
                foreach ($version['authors'] as $key => $author) {
                    $version['authors'][$key] = $this->createResult(Author::class, $author);
                }
            }
            if ($version['source']) {
                $version['source'] = $this->createResult(Source::class, $version['source']);
            }
            if (isset($version['dist']) && $version['dist']) {
                $version['dist'] = $this->createResult(Dist::class, $version['dist']);
            }

            $package['versions'][$branch] = $this->createResult(Version::class, $version);
        }

        $created = new Package();
        $created->fromArray($package);

        return $created;
    }

    /**
     * Dynamically create an AbstractResult of type $class and hydrate
     *
     * @param string $class DataObject class
     * @param array  $data Array of data
     * @return AbstractResult $class hydrated
     */
    protected function createResult(string $class, array $data): AbstractResult
    {
        $result = new $class();
        if (!$result instanceof AbstractResult) {
            throw new InvalidArgumentException('Class must extend AbstractResult');
        }
        $result->fromArray($data);

        return $result;
    }
}
