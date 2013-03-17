<?php

namespace spec\Packagist\Api\Result\Package;

use PHPSpec2\ObjectBehavior;

class Dist extends ObjectBehavior
{
    function let()
    {
        $this->fromArray(array(
            'type'      => 'git',
            'url'       => 'https://github.com/Sylius/Sylius.git',
            'reference' => 'cb0a489db41707d5df078f1f35e028e04ffd9e8e',
            'shasum'    => 'cb0a489db41707d5df078f1f35e028e04ffd9e8e',
        ));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Packagist\Api\Result\Package\Dist');
    }

    function it_gets_type()
    {
        $this->getType()->shouldReturn('git');
    }

    function it_gets_url()
    {
        $this->getUrl()->shouldReturn('https://github.com/Sylius/Sylius.git');
    }

    function it_gets_reference()
    {
        $this->getReference()->shouldReturn('cb0a489db41707d5df078f1f35e028e04ffd9e8e');
    }

    function it_gets_shasum()
    {
        $this->getShasum()->shouldReturn('cb0a489db41707d5df078f1f35e028e04ffd9e8e');
    }
}
