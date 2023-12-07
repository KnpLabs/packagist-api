<?php

declare(strict_types=1);

namespace spec\Packagist\Api\Result\Package;

use Packagist\Api\Result\Package\Maintainer;
use PhpSpec\ObjectBehavior;

class MaintainerSpec extends ObjectBehavior
{
    public function let()
    {
        $this->fromArray([
            'name'     => 'Saša Stamenković',
            'email'    => 'umpirsky@gmail.com',
            'homepage' => 'umpirsky.com',
            'avatar_url' => 'https://www.gravatar.com/avatar/example',
        ]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Maintainer::class);
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

    public function it_gets_avatar_url()
    {
        $this->getAvatarUrl()->shouldReturn('https://www.gravatar.com/avatar/example');
    }
}
