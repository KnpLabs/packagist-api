<?php

declare(strict_types=1);

namespace spec\Packagist\Api\Result\Advisory;

use Packagist\Api\Result\Advisory\Source;
use PhpSpec\ObjectBehavior;

class SourceSpec extends ObjectBehavior
{
    public function let()
    {
        $this->fromArray([
            'name' => 'FriendsOfPHP/security-advisories',
            'remoteId' => 'monolog/monolog/2014-12-29-1.yaml',
        ]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Source::class);
    }

    public function it_gets_name()
    {
        $this->getName()->shouldReturn('FriendsOfPHP/security-advisories');
    }

    public function it_gets_remote_id()
    {
        $this->getRemoteId()->shouldReturn('monolog/monolog/2014-12-29-1.yaml');
    }
}
