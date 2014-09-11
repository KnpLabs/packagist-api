<?php

namespace spec\Packagist\Api\Result;

use PhpSpec\ObjectBehavior;

class FactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Packagist\Api\Result\Factory');
    }

    function it_creates_search_results()
    {
        $data = json_decode(file_get_contents('spec/Packagist/Api/Fixture/search.json'), true);

        $results = $this->create($data);
        $results->shouldHaveCount(2);
        $results->shouldBeArray();
        foreach ($results as $result) {
            $result->shouldBeAnInstanceOf('Packagist\Api\Result\Result');
        }
    }

    function it_creates_packages()
    {
        $data = json_decode(file_get_contents('spec/Packagist/Api/Fixture/get.json'), true);

        $this->create($data)->shouldHaveType('Packagist\Api\Result\Package');
    }

    function it_creates_package_names()
    {
        $data = json_decode(file_get_contents('spec/Packagist/Api/Fixture/all.json'), true);

        $this->create($data)->shouldReturn(array(
            'sylius/addressing-bundle',
            'sylius/assortment-bundle',
            'sylius/blogger-bundle'
        ));
    }

    function it_creates_packages_with_missing_optional_data()
    {
        $data = json_decode(file_get_contents('spec/Packagist/Api/Fixture/get_nodist.json'), true);

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
