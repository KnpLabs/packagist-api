<?php

declare(strict_types=1);

namespace Packagist\Api\Result;

use Packagist\Api\Result\Package\Downloads;

class Package extends AbstractResult
{
    protected string $name = '';

    protected string $description = '';

    protected string $time = '';

    protected array $maintainers = [];

    protected array $versions = [];

    protected string $type = '';

    protected string $repository = '';

    protected Downloads $downloads;

    protected int $favers = 0;

    /**
     * @var bool|string
     */
    protected $abandoned = false;

    protected int $suggesters = 0;

    protected int $dependents = 0;

    protected int $githubStars = 0;

    protected int $githubForks = 0;

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getTime(): string
    {
        return $this->time;
    }

    /**
     * @return Package\Maintainer[]
     */
    public function getMaintainers(): array
    {
        return $this->maintainers;
    }

    /**
     * @return Package\Version[]
     */
    public function getVersions(): array
    {
        return $this->versions;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getRepository(): string
    {
        return $this->repository;
    }

    public function getDownloads(): Downloads
    {
        return $this->downloads;
    }

    public function getFavers(): int
    {
        return $this->favers;
    }

    public function isAbandoned(): bool
    {
        return (bool) $this->abandoned;
    }

    /**
     * Gets the package name to use as a replacement if this package is abandoned
     *
     * @return string|null
     */
    public function getReplacementPackage(): ?string
    {
        // The Packagist API will either return a boolean, or a string value for `abandoned`. It will be a boolean
        // if no replacement package was provided when the package was marked as abandoned in Packagist, or it will be
        // a string containing the replacement package name to use if one was provided.
        // @see https://github.com/KnpLabs/packagist-api/pull/56#discussion_r306426997
        if (is_string($this->abandoned)) {
            return $this->abandoned;
        }

        return null;
    }

    public function getSuggesters(): int
    {
        return $this->suggesters;
    }

    public function getDependents(): int
    {
        return $this->dependents;
    }

    public function getGithubStars(): int
    {
        return $this->githubStars;
    }

    public function getGithubForks(): int
    {
        return $this->githubForks;
    }
}
