<?php

namespace spec\Packagist\Api;

use Prophecy\Argument;
use PhpSpec\ObjectBehavior;
use PhpSpec\Exception\Example\MatcherException;
use Packagist\Api\PackagistApiClient;
use Packagist\Api\Result\Factory;
use Guzzle\Http\Message\Request;
use Guzzle\Http\Message\Response;
use Guzzle\Http\Client;

class PackagistApiClientFactorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Packagist\Api\PackagistApiClientFactory');
    }

    public function it_return_instance_of_PackagistApiClient()
    {
    	$this->getInstance();
    }
}
