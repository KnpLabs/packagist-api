<?php

namespace spec\Packagist\Api\Result;

use PHPSpec2\ObjectBehavior;
use PHPSpec2\Matcher\CustomMatchersProviderInterface;
use PHPSpec2\Matcher\InlineMatcher;
use PHPSpec2\Exception\Example\MatcherException;
use Mockery\Matcher\Type as TypeMatcher;
use spec\Packagist\Api\Fixture\FixtureLoader;

class Factory extends ObjectBehavior implements CustomMatchersProviderInterface
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Packagist\Api\Result\Factory');
    }

    function it_creates_search_results()
    {
        $data = json_decode(FixtureLoader::load('search.json'), true);

        $results = $this->create($data);
        $results->shouldHaveCount(2);
        $matcher = new TypeMatcher('Packagist\Api\Result\Result');
        foreach ($results->getWrappedSubject() as $result) {
            if (!$matcher->match($result)) {
                throw new MatcherException(sprintf('Result expected, got %s.', get_class($result)));
            }
        }
    }

    function it_creates_packages()
    {
        $data = json_decode(FixtureLoader::load('get.json'), true);

        $this->create($data)->shouldHaveType('Packagist\Api\Result\Package');
    }

    function it_creates_package_names()
    {
        $data = json_decode(FixtureLoader::load('all.json'), true);

        $this->create($data)->shouldReturn(array(
            'sylius/addressing-bundle',
            'sylius/assortment-bundle',
            'sylius/blogger-bundle'
        ));
    }

    function it_creates_packages_with_missing_optional_data()
    {
        $data = json_decode(FixtureLoader::load('get_nodist.json'), true);

        $this->create($data)->shouldHaveType('Packagist\Api\Result\Package');
    }

    static public function getMatchers()
    {
        return array(
            new InlineMatcher('haveBranch', function($subject, $key) {
                return array_key_exists($key, $subject);
            })
        );
    }
}
