<?php

namespace spec\Packagist\Api\Result\Package;

use PhpSpec\ObjectBehavior;

class AuthorSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(array(
            'name'     => 'Saša Stamenković',
            'email'    => 'umpirsky@gmail.com',
            'homepage' => 'umpirsky.com',
        ));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Packagist\Api\Result\Package\Author');
    }

    function it_gets_name()
    {
        $this->getName()->shouldReturn('Saša Stamenković');
    }

    function it_gets_email()
    {
        $this->getEmail()->shouldReturn('umpirsky@gmail.com');
    }

    function it_gets_homepage()
    {
        $this->getHomepage()->shouldReturn('umpirsky.com');
    }
}
