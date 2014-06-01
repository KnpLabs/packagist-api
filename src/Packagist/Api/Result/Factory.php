<?php

namespace Packagist\Api\Result;

use InvalidArgumentException;
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
     * @param array $results
     * @return ResultCollection
     */
    public function createSearchResults(array $results)
    {
        $created = new ResultCollection();

        if (isset($results['results'])) {
            foreach ($results['results'] as $key => $result) {
                $created->append(new Result($result));
            }
        }

        return $created;
    }

    /**
     * @param array $package
     * @return Package
     */
    public function createPackageResults(array $package)
    {
        if (isset($package['maintainers']) && $package['maintainers']) {
            foreach ($package['maintainers'] as $key => $maintainer) {
                $package['maintainers'][$key] = new Maintainer($maintainer);
            }
        }

        if (isset($package['downloads']) && $package['downloads']) {
            $package['downloads'] = new Downloads($package['downloads']);
        }

        if (isset($package['versions'])) {
            foreach ($package['versions'] as $branch => $version) {
                if (isset($version['authors']) && $version['authors']) {
                    foreach ($version['authors'] as $key => $author) {
                        $version['authors'][$key] = new Author($author);
                    }
                }
                $version['source'] = new Source($version['source']);
                if (isset($version['dist']) && $version['dist']) {
                    $version['dist'] = new Dist($version['dist']);
                }

                $package['versions'][$branch] = new Version($version);
            }
        }

        return new Package($package);
    }
}
