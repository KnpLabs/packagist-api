<?php

namespace Packagist\Api\Result;

use Packagist\Api\Result\Package\Source;
use Packagist\Api\Result\Package\Dist;
use Packagist\Api\Result\Package\Version;
use Packagist\Api\Result\Package\Author;
use Packagist\Api\Result\Package\Downloads;
use Packagist\Api\Result\Package\Maintainer;
use Packagist\Api\Result\Result;
use Packagist\Api\Result\ResultCollection;

class Factory
{
    /**
     * @param array $data
     * @return array
     */
    public function createSimpleResults(array $data)
    {
        return (array) $data['packageNames'];
    }

    /**
     * @param ResultCollection $resultCollection
     * @param array $results
     * @return ResultCollection
     */
    public function createSearchResults(ResultCollection $resultCollection, array $results)
    {
        $resultCollection = clone $resultCollection;

        if (isset($results['results']) === true && is_array($results['results'])) {
            foreach ($results['results'] as $key => $result) {
                $resultCollection->append(new Result($result));
            }
        }

        return $resultCollection;
    }

    /**
     * @param array $package
     * @return Package
     */
    public function createPackageResults(array $data)
    {
        $package = $data['package'];

        if (isset($package['maintainers']) === true && is_array($package['maintainers'])) {
            foreach ($package['maintainers'] as $key => $maintainer) {
                $package['maintainers'][$key] = new Maintainer($maintainer);
            }
        }

        if (isset($package['downloads']) === true && is_array($package['downloads'])) {
            $package['downloads'] = new Downloads($package['downloads']);
        }

        if (isset($package['versions']) === true && is_array($package['versions'])) {
            foreach ($package['versions'] as $branch => $version) {
                if (isset($version['authors']) === true && is_array($version['authors'])) {
                    foreach ($version['authors'] as $key => $author) {
                        $version['authors'][$key] = new Author($author);
                    }
                }
                $version['source'] = new Source($version['source']);
                if (isset($version['dist']) === true && is_array($version['dist'])) {
                    $version['dist'] = new Dist($version['dist']);
                }

                $package['versions'][$branch] = new Version($version);
            }
        }

        return new Package($package);
    }
}
