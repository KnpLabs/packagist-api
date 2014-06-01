<?php

namespace spec\Packagist\Api\Result;

use PhpSpec\ObjectBehavior;
//use spec\Packagist\Api\Fixture\FixtureLoader;

class FactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Packagist\Api\Result\Factory');
    }

    /**
     * @param string $name
     * @return string
     */
    private static function load($name)
    {
    	return file_get_contents(__DIR__ . '/../Fixture/' . $name);
    }

    function it_creates_search_results()
    {
        $data = json_decode(self::load('search.json'), true);

        $results = $this->create($data);
        $results->shouldHaveCount(2);
        $results->shouldBeAnInstanceOf('Packagist\Api\Result\ResultCollection');
        foreach ($results as $result) {
        	$result->shouldBeAnInstanceOf('Packagist\Api\Result\Result');
        }
    }

    function it_creates_packages()
    {
        $data = json_decode(self::load('get.json'), true);

        $this->create($data)->shouldHaveType('Packagist\Api\Result\Package');
    }

    function it_creates_package_names()
    {
        $data = json_decode(self::load('all.json'), true);

        $this->create($data)->shouldReturn(array(
            'sylius/addressing-bundle',
            'sylius/assortment-bundle',
            'sylius/blogger-bundle'
        ));
    }

    function it_creates_packages_with_missing_optional_data()
    {
        $data = json_decode(self::load('get_nodist.json'), true);

        $this->create($data)->shouldHaveType('Packagist\Api\Result\Package');
    }

    public function getMatchers()
    {
        return array(
            'haveBranch'  => function($subject, $key) {
                return array_key_exists($key, $subject);
            }
        );
    }
}
