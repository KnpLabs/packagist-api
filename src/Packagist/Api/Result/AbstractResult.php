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
            if (null === $value && !$this->isNullable($property)) {
                continue;
            }
            if (!property_exists($this, $property)) {
                continue;
            }
            $this->$property = $value;
        }
    }

    private function isNullable(string $property): bool
    {
        if (PHP_MAJOR_VERSION < 8 || !property_exists($this, $property)) {
            return true;
        }

        $reflection = new \ReflectionClass($this);
        try {
            $reflectionProperty = $reflection->getProperty($property);
        } catch (\ReflectionException $exception) {
            return false;
        }

        return null === $reflectionProperty->getDefaultValue();
    }
}
