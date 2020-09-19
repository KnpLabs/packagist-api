<?php

declare(strict_types=1);

namespace spec\Packagist\Api\Result\Package;

use Packagist\Api\Result\Package\Source;
use PhpSpec\ObjectBehavior;

class SourceSpec extends ObjectBehavior
{
    public function let()
    {
        $this->fromArray([
            'type'      => 'zip',
            'url'       => 'https://api.github.com/repos/Sylius/Sylius/zipball/cb0a489db41707d5df078f1f35e028e04ffd9e8e',
            'reference' => 'cb0a489db41707d5df078f1f35e028e04ffd9e8e',
        ]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Source::class);
    }

    public function it_gets_type()
    {
        $this->getType()->shouldReturn('zip');
    }

    public function it_gets_url()
    {
        $this->getUrl()->shouldReturn('https://api.github.com/repos/Sylius/Sylius/zipball/cb0a489db41707d5df078f1f35e028e04ffd9e8e');
    }

    public function it_gets_reference()
    {
        $this->getReference()->shouldReturn('cb0a489db41707d5df078f1f35e028e04ffd9e8e');
    }
}
