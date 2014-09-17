<?php

namespace spec\Packagist\Api\Result;

use PhpSpec\ObjectBehavior;

class ResultSpec extends ObjectBehavior
{
    function let()
    {
        $this->fromArray(array(
            'name'        => 'sylius/sylius',
            'description' => 'Modern ecommerce for Symfony2',
            'url'         => 'http://sylius.com',
            'downloads'   => 999999999,
            'favers'      => 999999999,
            'repository'  => 'https://github.com/Sylius/SyliusCartBundle'
        ));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Packagist\Api\Result\Result');
    }

    function it_is_a_packagist_result()
    {
        $this->shouldHaveType('Packagist\Api\Result\AbstractResult');
    }

    function it_gets_name()
    {
        $this->getName()->shouldReturn('sylius/sylius');
    }

    function it_gets_description()
    {
        $this->getDescription()->shouldReturn('Modern ecommerce for Symfony2');
    }

    function it_gets_url()
    {
        $this->getUrl()->shouldReturn('http://sylius.com');
    }

    function it_gets_downloads()
    {
        $this->getDownloads()->shouldReturn(999999999);
    }

    function it_gets_favers()
    {
        $this->getFavers()->shouldReturn(999999999);
    }

    function it_gets_repository()
    {
    	$this->getRepository()->shouldReturn('https://github.com/Sylius/SyliusCartBundle');
    }
}
