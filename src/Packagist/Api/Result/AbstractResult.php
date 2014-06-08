<?php

namespace Packagist\Api\Result;

use Doctrine\Common\Inflector\Inflector;

abstract class AbstractResult
{
    /**
     * @param array $data
     */
    public function fromArray(array $data)
    {
        foreach ($data as $key => $value) {
            $property = Inflector::camelize($key);
            $this->$property = $value;
        }
    }
}
