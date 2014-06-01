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
     * @throws InvalidArgumentException
     * @return \Packagist\Api\Result\ResultCollection|\Packagist\Api\Result\Package|string
     */
    public function create(array $data)
    {
        if (isset($data['results'])) {
            return $this->createSearchResults($data['results']);
        } elseif (isset($data['package'])) {
            return $this->createPackageResults($data['package']);
        } elseif (isset($data['packageNames'])) {
            return $data['packageNames'];
        }

        throw new InvalidArgumentException('Invalid input data.');
    }

    /**
     * @param array $results
     * @return ResultCollection
     */
    public function createSearchResults(array $results)
    {
        $created = new ResultCollection();

        foreach ($results as $key => $result) {
            $created->append(new Result($result));
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

        return new Package($package);
    }
}
