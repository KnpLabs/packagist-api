<?php

declare(strict_types=1);

namespace Packagist\Api\Result;

use Composer\MetadataMinifier\MetadataMinifier;
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
     * @return array|Package|Package[]|Result[]
     */
    public function create(array $data)
    {
        if (isset($data['results'])) {
            return $this->createSearchResults($data['results']);
        }
        if (isset($data['packages'])) {
            $packageOrResult = $data['packages'][array_key_first($data['packages'])];
            if (isset($packageOrResult['name'])) {
                // Used for /explore/popular.json
                return $this->createSearchResults($data['packages']);
            }
            if (isset($data['minified']) && 'composer/2.0' === $data['minified']) {
                // Used for /p2/<package>.json
                return $this->createComposer2PackagesResults($data['packages']);
            }
            // Used for /p/<package>.json
            return $this->createComposerPackagesResults($data['packages']);
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
     *
     * @return Result[]
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
     * @param array $packages
     * @return Package[]
     */
    public function createComposerPackagesResults(array $packages)
    {
        $created = array();

        foreach ($packages as $name => $package) {
            // Create an empty package, only contains versions
            $createdPackage = array(
                'versions' => [],
            );
            foreach ($package as $branch => $version) {
                $createdPackage['versions'][$branch] = $version;
            }

            $created[$name] = $this->createPackageResults($createdPackage);
        }

        return $created;
    }

    /**
     * @param array $package
     * @return Package
     */
    public function createPackageResults(array $package): Package
    {
        $package['description'] ??= '';
        $package['github_stars'] ??= 0;
        $package['github_watchers'] ??= 0;
        $package['github_forks'] ??= 0;
        $package['suggesters'] ??= 0;
        $package['dependents'] ??= 0;
        $package['favers'] ??= 0;

        if (isset($package['maintainers']) && $package['maintainers']) {
            foreach ($package['maintainers'] as $key => $maintainer) {
                $package['maintainers'][$key] = $this->createResult(Maintainer::class, $maintainer);
            }
        }

        if (isset($package['downloads']) && $package['downloads']) {
            $package['downloads'] = $this->createResult(Downloads::class, $package['downloads']);
        }

        foreach ($package['versions'] as $branch => $version) {
            if (empty($version['name']) && !empty($package['name'])) {
                $version['name'] = $package['name'];
            }

            if (isset($version['license'])) {
                $version['licenses'] = is_array($version['license']) ? $version['license'] : [$version['license']];
                unset($version['license']);
            }

            // Cast some potentially null properties to empty strings
            $version['name'] ??= '';
            $version['type'] ??= '';

            if (isset($version['authors']) && $version['authors']) {
                foreach ($version['authors'] as $key => $author) {
                    // Cast some potentially null properties to empty strings
                    $author['name'] ??= '';
                    $author['email'] ??= '';
                    $author['homepage'] ??= '';
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

    /**
     * @param array $packages
     * @return Package[]
     */
    public function createComposer2PackagesResults(array $packages): array
    {
        $created = [];

        foreach ($packages as $name => $package) {
            $package = MetadataMinifier::expand($package);
            // Create an empty package, only contains versions
            $createdPackage = array(
                'versions' => [],
            );
            foreach ($package as $version) {
                $createdPackage['versions'][$version['version']] = $version;
            }

            $created[$name] = $this->createPackageResults($createdPackage);
        }

        return $created;
    }
}
