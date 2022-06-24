<?php

namespace Packagist\Api\Result;

use Packagist\Api\Result\AbstractResult;
use Packagist\Api\Result\Advisory\Source;

class Advisory extends AbstractResult
{
    protected string $advisoryId;

    protected string $packageName;

    protected string $remoteId;

    protected string $title;

    protected string $link;

    protected string $cve;

    protected string $affectedVersions;

    /**
     * @var Source[]
     */
    protected array $sources;

    protected string $reportedAt;

    protected string $composerRepository;

    public function getAdvisoryId(): string
    {
        return $this->advisoryId;
    }

    public function getPackageName(): string
    {
        return $this->packageName;
    }

    public function getRemoteId(): string
    {
        return $this->remoteId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function getCve(): string
    {
        return $this->cve;
    }

    public function getAffectedVersions(): string
    {
        return $this->affectedVersions;
    }

    /**
     * @return Source[]
     */
    public function getSources(): array
    {
        return $this->sources;
    }

    public function getReportedAt(): string
    {
        return $this->reportedAt;
    }

    public function getComposerRepository(): string
    {
        return $this->composerRepository;
    }
}
