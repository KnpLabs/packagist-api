<?php

namespace spec\Packagist\Api\Result\Package;

use PHPSpec2\ObjectBehavior;

class Version extends ObjectBehavior
{
    /**
     * @param Packagist\Api\Result\Package\Author $author
     * @param Packagist\Api\Result\Package\Source $source
     * @param Packagist\Api\Result\Package\Dist   $dist
     * @param DateTime                            $time
     */
    function let($author, $source, $dist, $time)
    {
        $this->fromArray(array(
            'name'               => 'sylius/sylius',
            'description'        => 'Modern ecommerce for Symfony2',
            'keywords'           => array('sylius'),
            'homepage'           => 'http://sylius.com',
            'version'            => 'dev-checkout',
            'version_normalized' => 'dev-checkout',
            'license'            => 'MIT',
            'authors'            => array($author),
            'source'             => $source,
            'dist'               => $dist,
            'type'               => 'library',
            'time'               => $time,
            'autoload'           => array('psr-0' => array('Context' => 'features/')),
            'extra'              => array('symfony-app-dir' => 'sylius'),
            'require'            => array('php' => '>=5.4'),
            'require-dev'        => array('phpspec/phpspec2' => 'dev-develop'),
            'bin'                => array('bin/sylius'),
        ));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Packagist\Api\Result\Package\Version');
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

    function it_gets_keywords()
    {
        $this->getKeywords()->shouldReturn(array('sylius'));
    }

    function it_gets_homepage()
    {
        $this->getHomepage()->shouldReturn('http://sylius.com');
    }

    function it_gets_version()
    {
        $this->getVersion()->shouldReturn('dev-checkout');
    }

    function it_gets_normalized_version()
    {
        $this->getVersionNormalized()->shouldReturn('dev-checkout');
    }

    function it_gets_license()
    {
        $this->getLicense()->shouldReturn('MIT');
    }

    function it_has_authors($author)
    {
        $this->getAuthors()->shouldReturn(array($author));
    }

    function it_gets_source($source)
    {
        $this->getSource()->shouldReturn($source);
    }

    function it_gets_dist($dist)
    {
        $this->getDist()->shouldReturn($dist);
    }

    function it_gets_type()
    {
        $this->getType()->shouldReturn('library');
    }

    function it_gets_time($time)
    {
        $this->getTime()->shouldReturn($time);
    }

    function it_gets_autoload()
    {
        $this->getAutoload()->shouldReturn(array('psr-0' => array('Context' => 'features/')));
    }

    function it_gets_extra()
    {
        $this->getExtra()->shouldReturn(array('symfony-app-dir' => 'sylius'));
    }

    function it_gets_require()
    {
        $this->getRequire()->shouldReturn(array('php' => '>=5.4'));
    }

    function it_gets_require_dev()
    {
        $this->getRequireDev()->shouldReturn(array('phpspec/phpspec2' => 'dev-develop'));
    }

    function it_gets_bin()
    {
        $this->getBin()->shouldReturn(array('bin/sylius'));
    }
}
