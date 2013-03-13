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
            $created[$key] = new Result();
            $created[$key]->fromArray($result);
        }

        return $created;
    }

    public function createPackageResults(array $packages)
    {
        $created = array();
        foreach ($packages as $branch => $package) {
            foreach ($package['authors'] as $key => $author) {
                $package['authors'][$key] = new Package\Author();
                $package['authors'][$key]->fromArray($author);
            }

            $created[$branch] = new Package();
            $created[$branch]->fromArray($package);
        }

        return $created;
    }
}
