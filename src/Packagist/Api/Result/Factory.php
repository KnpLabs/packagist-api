<?php

namespace Packagist\Api\Result;

use Packagist\Api\Result\Package\Source;
use Packagist\Api\Result\Package\Version;
use Packagist\Api\Result\Result;
use Packagist\Api\Result\ResultCollection;

class Factory
{
    /**
     * Create a simple array of result
     *
     * @param array $data
     *
     * @return array
     */
    public function createSimpleResults(array $data)
    {
        return (array) $data['packageNames'];
    }

    /**
     * Create a ResultCollection by array
     *
     * @param ResultCollection $resultCollection
     * @param array            $results
     *
     * @return ResultCollection
     */
    public function createSearchResults(ResultCollection $resultCollection, array $results)
    {
        $resultCollection = clone $resultCollection;

        if (isset($results['results']) === true && is_array($results['results']) === true) {
            foreach ($results['results'] as $key => $result) {
                $resultCollection->append(new Result($result));
            }
        }

        return $resultCollection;
    }

    /**
     * Create a Package DTO by array
     *
     * @param array $data
     *
     * @return Package
     */
    public function createPackageResults(array $data)
    {
        $package = $data['package'];
        $package = $this->hydrateCollection($package, 'mainteners', 'Packagist\Api\Result\Package\Maintainer');
        $package = $this->hydrateSimple($package, 'downloads', 'Packagist\Api\Result\Package\Downloads');

        if (isset($package['versions']) === true && is_array($package['versions']) === true) {
            foreach ($package['versions'] as $branch => $version) {
                $version = $this->hydrateCollection(
                    $version,
                    'authors',
                    'Packagist\Api\Result\Package\Author'
                );
                $version = $this->hydrateSimple(
                    $version,
                    'dist',
                    'Packagist\Api\Result\Package\Dist'
                );
                $version['source']            = new Source($version['source']);
                $package['versions'][$branch] = new Version($version);
            }
        }

        return new Package($package);
    }

    /**
     * @param array  $package
     * @param string $arrayKey
     * @param string $className
     *
     * @return array
     */
    private function hydrateCollection(array $package, $arrayKey, $className)
    {
        if (isset($package[$arrayKey]) === true && is_array($package[$arrayKey]) === true) {
            foreach ($package[$arrayKey] as $key => $values) {
                $package[$arrayKey][$key] = new $className($values);
            }
        }

        return $package;
    }

    /**
     * @param array  $package
     * @param string $arrayKey
     * @param string $className
     *
     * @return array
     */
    private function hydrateSimple(array $package, $arrayKey, $className)
    {
        if (isset($package[$arrayKey]) === true && is_array($package[$arrayKey]) === true) {
            $package[$arrayKey] = new $className($package[$arrayKey]);
        }

        return $package;
    }
}
