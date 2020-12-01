<?php

declare(strict_types=1);

namespace spec\Packagist\Api\Result\Package;

use Packagist\Api\Result\Package\Dist;
use PhpSpec\ObjectBehavior;

class DistSpec extends ObjectBehavior
{
    public function let()
    {
        $this->fromArray([
            'type'      => 'git',
            'url'       => 'https://github.com/Sylius/Sylius.git',
            'reference' => 'cb0a489db41707d5df078f1f35e028e04ffd9e8e',
            'shasum'    => 'cb0a489db41707d5df078f1f35e028e04ffd9e8e',
        ]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Dist::class);
    }

    public function it_gets_type()
    {
        $this->getType()->shouldReturn('git');
    }

    public function it_gets_url()
    {
        $this->getUrl()->shouldReturn('https://github.com/Sylius/Sylius.git');
    }

    public function it_gets_reference()
    {
        $this->getReference()->shouldReturn('cb0a489db41707d5df078f1f35e028e04ffd9e8e');
    }

    public function it_gets_shasum()
    {
        $this->getShasum()->shouldReturn('cb0a489db41707d5df078f1f35e028e04ffd9e8e');
    }
}
