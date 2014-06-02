<?php

namespace spec\Packagist\Api;

use PhpSpec\ObjectBehavior;

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
