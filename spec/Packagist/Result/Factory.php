<?php

namespace spec\Packagist\Result;

use PHPSpec2\ObjectBehavior;
use PHPSpec2\Matcher\CustomMatchersProviderInterface;
use PHPSpec2\Matcher\InlineMatcher;
use PHPSpec2\Exception\Example\MatcherException;
use Mockery\Matcher\Type as TypeMatcher;
use spec\Packagist\Fixture\FixtureLoader;

class Factory extends ObjectBehavior implements CustomMatchersProviderInterface
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Packagist\Result\Factory');
    }

    function it_creates_search_results()
    {
        $data = json_decode(FixtureLoader::load('search.json'), true);

        $results = $this->create($data);
        $results->shouldHaveCount(2);
        $matcher = new TypeMatcher('Packagist\Result\Result');
        foreach ($results->getWrappedSubject() as $result) {
            if (!$matcher->match($result)) {
                throw new MatcherException(sprintf('Result expected, got %s.', get_class($result)));
            }
        }
    }

    function it_creates_packages()
    {
        $data = json_decode(FixtureLoader::load('get.json'), true);

        $packages = $this->create($data);
        $packages->shouldHaveCount(2);
        $packages->shouldHaveBranch('dev-master');
        $packages->shouldHaveBranch('dev-checkout');
        $matcher = new TypeMatcher('Packagist\Result\Package');
        foreach ($packages->getWrappedSubject() as $package) {
            if (!$matcher->match($package)) {
                throw new MatcherException(sprintf('Package expected, got %s.', get_class($package)));
            }
        }
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

    static public function getMatchers()
    {
        return array(
            new InlineMatcher('haveBranch', function($subject, $key) {
                return array_key_exists($key, $subject);
            })
        );
    }
}
