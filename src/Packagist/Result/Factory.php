<?php

namespace Packagist\Result;

use InvalidArgumentException;

class Factory implements FactoryInterface
{
    public function create(array $data)
    {
        if (isset($data['results'])) {
            return $this->createSearchResults($data['results']);
        } elseif (isset($data['packages'])) {
            return $this->createPackageResults(array_pop($data['packages']));
        }

        throw new InvalidArgumentException('Invalid input data.');
    }

    public function createSearchResults(array $results)
    {
        $created = array();
        foreach ($results as $key => $result) {
            $created[$key] = $this->createResult('Packagist\Result\Result', $result);
        }

        return $created;
    }

    public function createPackageResults(array $packages)
    {
        $created = array();
        foreach ($packages as $branch => $package) {
            if (isset($package['authors'])) {
                foreach ($package['authors'] as $key => $author) {
                    $package['authors'][$key] = $this->createResult('Packagist\Result\Package\Author', $author);
                }
            }

            $package['source'] = $this->createResult('Packagist\Result\Package\Source', $package['source']);
            $package['dist'] = $this->createResult('Packagist\Result\Package\Dist', $package['dist']);

            $created[$branch] = new Package();
            $created[$branch]->fromArray($package);
        }

        return $created;
    }

    protected function createResult($class, $data)
    {
        $result = new $class();
        $result->fromArray($data);

        return $result;
    }
}
