<?php

declare(strict_types=1);

namespace spec\Packagist\Api\Result\Package;

use Packagist\Api\Result\Package\Author;
use PhpSpec\ObjectBehavior;

class AuthorSpec extends ObjectBehavior
{
    public function let()
    {
        $this->fromArray([
            'name'     => 'Saša Stamenković',
            'email'    => 'umpirsky@gmail.com',
            'homepage' => 'umpirsky.com',
            'role'     => 'lead',
        ]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Author::class);
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
