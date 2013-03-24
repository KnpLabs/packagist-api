<?php

namespace spec\Packagist\Api\Result;

use PHPSpec2\ObjectBehavior;

class Package extends ObjectBehavior
{
    /**
     * @param Packagist\Api\Result\Package\Maintainer $maintainer
     * @param Packagist\Api\Result\Package\Version    $version
     * @param Packagist\Api\Result\Package\Source     $source
     * @param Packagist\Api\Result\Package\Dist       $dist
     * @param Packagist\Api\Result\Package\Downloads  $downloads
     * @param DateTime                                $time
     */
    function let($maintainer, $version, $source, $dist, $downloads, $time)
    {
        $this->fromArray(array(
            'name'        => 'sylius/sylius',
            'description' => 'Modern ecommerce for Symfony2',
            'time'        => $time,
            'maintainers' => array($maintainer),
            'versions'    => array($version),
            'type'        => 'library',
            'repository'  => 'https://github.com/Sylius/Sylius.git',
            'downloads'   => $downloads,
            'favers'      => 9999999999,
        ));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Packagist\Api\Result\Package');
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

    function it_gets_time($time)
    {
        $this->getTime()->shouldReturn($time);
    }

    function it_gets_maintainers($maintainer)
    {
        $this->getMaintainers()->shouldReturn(array($maintainer));
    }

    function it_gets_versions($version)
    {
        $this->getVersions()->shouldReturn(array($version));
    }

    function it_gets_type()
    {
        $this->getType()->shouldReturn('library');
    }

    function it_gets_repository()
    {
        $this->getRepository()->shouldReturn('https://github.com/Sylius/Sylius.git');
    }

    function it_gets_downloads($downloads)
    {
        $this->getDownloads()->shouldReturn($downloads);
    }

    function it_gets_favers()
    {
        $this->getFavers()->shouldReturn(9999999999);
    }
}
