<?php

namespace spec\Packagist\Api\Fixture;

class FixtureLoader
{
    /**
     * @param string $name
     * @return string
     */
    public static function load($name)
    {
        return file_get_contents(__DIR__ . '/' . $name);
    }
}
