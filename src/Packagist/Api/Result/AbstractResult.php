<?php

namespace Packagist\Api\Result;

use Doctrine\Common\Inflector\Inflector;

abstract class AbstractResult
{
    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            $property = Inflector::camelize($key);
            $this->$property = $value;
        }
    }
}
