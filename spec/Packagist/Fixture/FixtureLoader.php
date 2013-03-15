<?php

namespace spec\Packagist\Fixture;

class FixtureLoader
{
    public static function load($name)
    {
        return file_get_contents(__DIR__.'/'.$name);
    }
}
