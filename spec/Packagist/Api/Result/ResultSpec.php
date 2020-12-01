<?php

declare(strict_types=1);

namespace spec\Packagist\Api\Result;

use Packagist\Api\Result\AbstractResult;
use Packagist\Api\Result\Result;
use PhpSpec\ObjectBehavior;

class ResultSpec extends ObjectBehavior
{
    public function let()
    {
        $this->fromArray([
            'name'        => 'sylius/sylius',
            'description' => 'Modern ecommerce for Symfony2',
            'url'         => 'http://sylius.com',
            'downloads'   => 999999999,
            'favers'      => 999999999,
            'repository'  => 'https://github.com/Sylius/SyliusCartBundle',
        ]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Result::class);
    }

    public function it_is_a_packagist_result()
    {
        $this->shouldHaveType(AbstractResult::class);
    }

    public function it_gets_name()
    {
        $this->getName()->shouldReturn('sylius/sylius');
    }

    public function it_gets_description()
    {
        $this->getDescription()->shouldReturn('Modern ecommerce for Symfony2');
    }

    public function it_gets_url()
    {
        $this->getUrl()->shouldReturn('http://sylius.com');
    }

    public function it_gets_downloads()
    {
        $this->getDownloads()->shouldReturn(999999999);
    }

    public function it_gets_favers()
    {
        $this->getFavers()->shouldReturn(999999999);
    }

    public function it_gets_repository()
    {
    	$this->getRepository()->shouldReturn('https://github.com/Sylius/SyliusCartBundle');
    }
}
