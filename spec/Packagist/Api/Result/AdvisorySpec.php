<?php

declare(strict_types=1);

namespace spec\Packagist\Api\Result;

use Packagist\Api\Result\AbstractResult;
use Packagist\Api\Result\Advisory;
use Packagist\Api\Result\Advisory\Source;
use PhpSpec\ObjectBehavior;

class AdvisorySpec extends ObjectBehavior
{
    private $source;

    private function data()
    {
        return [
            'advisoryId' => 'PKSA-dmw8-jd8k-q3c6',
            'packageName' => 'monolog/monolog',
            'remoteId' => 'monolog/monolog/2014-12-29-1.yaml',
            'title' => 'Header injection in NativeMailerHandler',
            'link' => 'https://github.com/Seldaek/monolog/pull/448#issuecomment-68208704',
            'cve' => 'test-value',
            'affectedVersions' => '>=1.8.0,<1.12.0',
            'sources' => [$this->source],
            'reportedAt' => '2014-12-29 00:00:00',
            'composerRepository' => 'https://packagist.org',
        ];
    }

    public function let(Source $source)
    {
        $this->source = $source;
        $this->fromArray($this->data());
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Advisory::class);
    }

    public function it_is_a_packagist_result()
    {
        $this->shouldHaveType(AbstractResult::class);
    }

    public function it_gets_advisory_id()
    {
        $this->getAdvisoryId()->shouldReturn($this->data()['advisoryId']);
    }

    public function it_gets_package_name()
    {
        $this->getPackageName()->shouldReturn($this->data()['packageName']);
    }

    public function it_gets_remote_id()
    {
        $this->getRemoteId()->shouldReturn($this->data()['remoteId']);
    }

    public function it_gets_title()
    {
        $this->getTitle()->shouldReturn($this->data()['title']);
    }

    public function it_gets_link()
    {
        $this->getLink()->shouldReturn($this->data()['link']);
    }

    public function it_gets_cve()
    {
        $this->getCve()->shouldReturn($this->data()['cve']);
    }

    public function it_gets_affected_versions()
    {
        $this->getAffectedVersions()->shouldReturn($this->data()['affectedVersions']);
    }

    public function it_gets_sources()
    {
        $this->getSources()->shouldReturn($this->data()['sources']);
    }

    public function it_gets_reported_at()
    {
        $this->getReportedAt()->shouldReturn($this->data()['reportedAt']);
    }

    public function it_gets_composer_repository()
    {
        $this->getComposerRepository()->shouldReturn($this->data()['composerRepository']);
    }
}
