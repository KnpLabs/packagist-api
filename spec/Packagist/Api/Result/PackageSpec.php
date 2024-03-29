<?php

declare(strict_types=1);

namespace spec\Packagist\Api\Result;

use Packagist\Api\Result\AbstractResult;
use Packagist\Api\Result\Package;
use Packagist\Api\Result\Package\Downloads;
use Packagist\Api\Result\Package\Maintainer;
use Packagist\Api\Result\Package\Version;
use PhpSpec\ObjectBehavior;

class PackageSpec extends ObjectBehavior
{
    public function let(Maintainer $maintainer, Version $version, Downloads $downloads)
    {
        $this->fromArray([
            'name'        => 'sylius/sylius',
            'description' => 'Modern ecommerce for Symfony2',
            'time'        => '2020-01-25T15:11:19+00:00',
            'maintainers' => [$maintainer],
            'versions'    => [$version],
            'type'        => 'library',
            'repository'  => 'https://github.com/Sylius/Sylius.git',
            'downloads'   => $downloads,
            'favers'      => 9999999999,
            'suggesters'  => 21,
            'dependents'  => 42,
            'github_stars' => 3086,
            'github_forks' => 1124,
            'github_watchers' => 480,
            'github_open_issues' => 32,
            // A dynamic property, causes deprecation warnings in PHP 8.2+ and is now ignored in AbstractResult
            'supports_cheese' => true,
            'language' => 'PHP',
        ]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Package::class);
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

    public function it_gets_time()
    {
        $this->getTime()->shouldReturn('2020-01-25T15:11:19+00:00');
    }

    public function it_gets_maintainers($maintainer)
    {
        $this->getMaintainers()->shouldReturn([$maintainer]);
    }

    public function it_gets_versions($version)
    {
        $this->getVersions()->shouldReturn([$version]);
    }

    public function it_gets_type()
    {
        $this->getType()->shouldReturn('library');
    }

    public function it_gets_repository()
    {
        $this->getRepository()->shouldReturn('https://github.com/Sylius/Sylius.git');
    }

    public function it_gets_downloads($downloads)
    {
        $this->getDownloads()->shouldReturn($downloads);
    }

    public function it_gets_favers()
    {
        $this->getFavers()->shouldReturn(9999999999);
    }

    public function it_gets_abandoned()
    {
        $this->isAbandoned()->shouldReturn(false);
    }

    public function it_gets_abandoned_returning_true()
    {
        $this->fromArray([
            'name'        => 'typo3/ldap',
            'abandoned'   => true,
        ]);

        $this->isAbandoned()->shouldReturn(true);
    }

    public function it_gets_replacement_package()
    {
        $this->fromArray([
            'name'        => 'typo3/ldap',
            'abandoned'   => 'neos/ldap',
        ]);

        $this->getReplacementPackage()->shouldReturn('neos/ldap');
    }

    public function it_gets_replacement_package_returning_null()
    {
        $this->fromArray([
            'name'        => 'typo3/ldap',
            'abandoned'   => false,
        ]);

        $this->getReplacementPackage()->shouldReturn(null);
    }

    public function it_gets_suggesters()
    {
        $this->getSuggesters()->shouldReturn(21);
    }

    public function it_gets_dependents()
    {
        $this->getDependents()->shouldReturn(42);
    }

    public function it_gets_github_stars()
    {
        $this->getGithubStars()->shouldReturn(3086);
    }

    public function it_gets_github_forks()
    {
        $this->getGithubForks()->shouldReturn(1124);
    }

    public function it_gets_github_watchers()
    {
        $this->getGithubWatchers()->shouldReturn(480);
    }

    public function it_gets_github_open_issues()
    {
        $this->getGithubOpenIssues()->shouldReturn(32);
    }

    public function it_gets_language()
    {
        $this->getLanguage()->shouldReturn('PHP');
    }
}
