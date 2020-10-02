<?php

declare(strict_types=1);

namespace spec\Packagist\Api\Result\Package;

use Packagist\Api\Result\AbstractResult;
use Packagist\Api\Result\Package\Author;
use Packagist\Api\Result\Package\Dist;
use Packagist\Api\Result\Package\Source;
use Packagist\Api\Result\Package\Version;
use PhpSpec\ObjectBehavior;

class VersionSpec extends ObjectBehavior
{
    public function let(Author $author, Source $source, Dist $dist)
    {
        $this->fromArray([
            'name'               => 'sylius/sylius',
            'description'        => 'Modern ecommerce for Symfony2',
            'keywords'           => ['sylius'],
            'homepage'           => 'http://sylius.com',
            'version'            => 'dev-checkout',
            'version_normalized' => 'dev-checkout',
            'licenses'           => ['MIT'],
            'authors'            => [$author],
            'source'             => $source,
            'dist'               => $dist,
            'type'               => 'library',
            'time'               => '2020-01-25T15:11:19+00:00',
            'autoload'           => ['psr-0' => ['Context' => 'features/']],
            'extra'              => ['symfony-app-dir' => 'sylius'],
            'require'            => ['php' => '>=5.4'],
            'require-dev'        => ['phpspec/phpspec2' => 'dev-develop'],
            'suggest'            => ['illuminate/events' => 'Required to use the observers with Eloquent (5.1.*).'],
            'bin'                => ['bin/sylius'],
        ]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Version::class);
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

    public function it_gets_keywords()
    {
        $this->getKeywords()->shouldReturn(['sylius']);
    }

    public function it_gets_homepage()
    {
        $this->getHomepage()->shouldReturn('http://sylius.com');
    }

    public function it_gets_version()
    {
        $this->getVersion()->shouldReturn('dev-checkout');
    }

    public function it_gets_normalized_version()
    {
        $this->getVersionNormalized()->shouldReturn('dev-checkout');
    }

    public function it_gets_licenses()
    {
        $this->getLicenses()->shouldReturn(['MIT']);
    }

    public function it_has_authors($author)
    {
        $this->getAuthors()->shouldReturn([$author]);
    }

    public function it_gets_source($source)
    {
        $this->getSource()->shouldReturn($source);
    }

    public function it_gets_dist($dist)
    {
        $this->getDist()->shouldReturn($dist);
    }

    public function it_gets_type()
    {
        $this->getType()->shouldReturn('library');
    }

    public function it_gets_time()
    {
        $this->getTime()->shouldReturn('2020-01-25T15:11:19+00:00');
    }

    public function it_gets_autoload()
    {
        $this->getAutoload()->shouldReturn(['psr-0' => ['Context' => 'features/']]);
    }

    public function it_gets_extra()
    {
        $this->getExtra()->shouldReturn(['symfony-app-dir' => 'sylius']);
    }

    public function it_gets_require()
    {
        $this->getRequire()->shouldReturn(['php' => '>=5.4']);
    }

    public function it_gets_require_dev()
    {
        $this->getRequireDev()->shouldReturn(['phpspec/phpspec2' => 'dev-develop']);
    }

    public function it_gets_bin()
    {
        $this->getBin()->shouldReturn(['bin/sylius']);
    }

    public function it_gets_suggest()
    {
        $this->getSuggest()->shouldReturn([
        	'illuminate/events' => 'Required to use the observers with Eloquent (5.1.*).',
		]);
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
}
