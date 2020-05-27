<?php

namespace Packagist\Api\Result;

use Doctrine\Common\Inflector\Inflector;
use Doctrine\Inflector\InflectorFactory;

abstract class AbstractResult
{
    /**
     * @param array $data
     */
    public function fromArray(array $data)
    {
        $inflector = \class_exists(InflectorFactory::class) ? InflectorFactory::create()->build() : null;
        foreach ($data as $key => $value) {
            $property = null === $inflector ? Inflector::camelize($key) : $inflector->camelize($key);
            $this->$property = $value;
        }
    }
}
