<?php

namespace Packagist\Api\Result;

use InvalidArgumentException;

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
        } elseif (isset($data['packages'])) {
            return $this->createSearchResults($data['packages']);
        } elseif (isset($data['package'])) {
            return $this->createPackageResults($data['package']);
        } elseif (isset($data['packageNames'])) {
            return $data['packageNames'];
        }

        throw new InvalidArgumentException('Invalid input data.');
    }

    /**
     * Create a collection of \Packagist\Api\Result\Result

     * @param array $results
     *
     * @return array
     */
    public function createSearchResults(array $results)
    {
        $created = array();
        foreach ($results as $key => $result) {
            $created[$key] = $this->createResult('Packagist\Api\Result\Result', $result);
        }

        return $created;
    }

    /**
     * Parse array to \Packagist\Api\Result\Result

     * @param array $package
     *
     * @return Package
     */
    public function createPackageResults(array $package)
    {
        $created = array();

        if (isset($package['maintainers']) && $package['maintainers']) {
            foreach ($package['maintainers'] as $key => $maintainer) {
                $package['maintainers'][$key] = $this->createResult('Packagist\Api\Result\Package\Maintainer', $maintainer);
            }
        }

        if (isset($package['downloads']) && $package['downloads']) {
            $package['downloads'] = $this->createResult('Packagist\Api\Result\Package\Downloads', $package['downloads']);
        }

        foreach ($package['versions'] as $branch => $version) {
            if (isset($version['authors']) && $version['authors']) {
                foreach ($version['authors'] as $key => $author) {
                    $version['authors'][$key] = $this->createResult('Packagist\Api\Result\Package\Author', $author);
                }
            }
            $version['source'] = $this->createResult('Packagist\Api\Result\Package\Source', $version['source']);
            if (isset($version['dist']) && $version['dist']) {
                $version['dist'] = $this->createResult('Packagist\Api\Result\Package\Dist', $version['dist']);
            }

            $package['versions'][$branch] = $this->createResult('Packagist\Api\Result\Package\Version', $version);
        }

        $created = new Package();
        $created->fromArray($package);

        return $created;
    }

    /**
     * Dynamically create DataObject of type $class and hydrate
     *
     * @param string $class DataObject class
     * @param array  $data Array of data
     *
     * @return mixed DataObject $class hydrated
     */
    protected function createResult($class, array $data)
    {
        $result = new $class();
        $result->fromArray($data);

        return $result;
    }
}
