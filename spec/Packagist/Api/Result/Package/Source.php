<?php

namespace spec\Packagist\Api\Result\Package;

use PHPSpec2\ObjectBehavior;

class Source extends ObjectBehavior
{
    function let()
    {
        $this->fromArray(array(
            'type'      => 'zip',
            'url'       => 'https://api.github.com/repos/Sylius/Sylius/zipball/cb0a489db41707d5df078f1f35e028e04ffd9e8e',
            'reference' => 'cb0a489db41707d5df078f1f35e028e04ffd9e8e',
        ));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Packagist\Api\Result\Package\Source');
    }

    function it_gets_type()
    {
        $this->getType()->shouldReturn('zip');
    }

    function it_gets_url()
    {
        $this->getUrl()->shouldReturn('https://api.github.com/repos/Sylius/Sylius/zipball/cb0a489db41707d5df078f1f35e028e04ffd9e8e');
    }

    function it_gets_reference()
    {
        $this->getReference()->shouldReturn('cb0a489db41707d5df078f1f35e028e04ffd9e8e');
    }
}
