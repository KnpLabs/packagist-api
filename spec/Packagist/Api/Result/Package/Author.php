<?php

namespace spec\Packagist\Api\Result\Package;

use PHPSpec2\ObjectBehavior;

class Author extends ObjectBehavior
{
    public function let()
    {
        $this->fromArray(array(
            'name'     => 'Saša Stamenković',
            'email'    => 'umpirsky@gmail.com',
            'homepage' => 'umpirsky.com',
            'role'     => 'lead'
        ));
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Packagist\Api\Result\Package\Author');
    }

    public function it_gets_name()
    {
        $this->getName()->shouldReturn('Saša Stamenković');
    }

    public function it_gets_email()
    {
        $this->getEmail()->shouldReturn('umpirsky@gmail.com');
    }

    public function it_gets_homepage()
    {
        $this->getHomepage()->shouldReturn('umpirsky.com');
    }

    public function it_gets_role()
    {
        $this->getRole()->shouldReturn('lead');
    }
}
