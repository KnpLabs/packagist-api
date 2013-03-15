<?php

namespace spec\Packagist\Result;

use PHPSpec2\ObjectBehavior;
use spec\Packagist\Fixture\FixtureLoader;

class Factory extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Packagist\Result\Factory');
    }

    function it_creates_search_results()
    {
        $data = json_decode(FixtureLoader::load('search.json'), true);

        $this->create($data)->shouldHaveCount(15);
    }

    function it_creates_package_result()
    {
        $data = json_decode(FixtureLoader::load('get.json'), true);

        $this->create($data)->shouldHaveCount(2);
    }
}
