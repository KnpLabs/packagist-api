<?php

namespace spec\Packagist\Api\Result;

use PhpSpec\ObjectBehavior;

class PackageSpec extends ObjectBehavior
{
    /**
     * @param \Packagist\Api\Result\Package\Maintainer $maintainer
     * @param \Packagist\Api\Result\Package\Version    $version
     * @param \Packagist\Api\Result\Package\Source     $source
     * @param \Packagist\Api\Result\Package\Dist       $dist
     * @param \Packagist\Api\Result\Package\Downloads  $downloads
     * @param \DateTime                                $time
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
            'suggesters'  => 21,
            'dependents'  => 42,
            'github_stars' => 3086,
            'github_forks' => 1124
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

    function it_gets_abandoned_bool()
    {
        $this->isAbandoned()->shouldReturn(false);
    }

    function it_gets_abandoned_package_replacement()
    {
        $this->fromArray(array(
            'name'        => 'typo3/ldap',
            'description' => 'Ldap Authentication for Flow',
            'type'        => 'library',
            'abandoned'   => 'neos/ldap',
        ));

        $this->getAbandoned()->shouldReturn('neos/ldap');
        // Deprecated/legacy flag
        $this->isAbandoned()->shouldReturn(true);
    }

    function it_gets_suggesters()
    {
        $this->getSuggesters()->shouldReturn(21);
    }

    function it_gets_dependents()
    {
        $this->getDependents()->shouldReturn(42);
    }

    function it_gets_github_stars()
    {
        $this->getGithubStars()->shouldReturn(3086);
    }

    function it_gets_github_forks()
    {
        $this->getGithubForks()->shouldReturn(1124);
    }
}
