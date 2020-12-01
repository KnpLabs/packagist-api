<?php

declare(strict_types=1);

namespace Packagist\Api\Result;

use Doctrine\Inflector\InflectorFactory;

abstract class AbstractResult
{
    public function fromArray(array $data): void
    {
        $inflector = InflectorFactory::create()->build();
        foreach ($data as $key => $value) {
            $property = $inflector->camelize($key);
            $this->$property = $value;
        }
    }
}
