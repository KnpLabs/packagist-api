<?php

declare(strict_types=1);

namespace Packagist\Api\Result\Package;

use Packagist\Api\Result\AbstractResult;

class Version extends AbstractResult
{
    protected string $name;

    protected string $description;

    protected array $keywords;

    protected string $homepage;

    protected string $version;

    protected string $versionNormalized;

    protected string $license;

    protected array $authors;

    protected Source $source;

    protected Dist $dist;

    protected string $type;

    protected string $time;

    protected array $autoload;

    protected array $extra;

    protected array $require;

    protected array $requireDev;

    protected string $conflict;

    protected string $provide;

    protected string $replace;

    protected string $bin;

    protected array $suggest;

    /**
     * @var bool|string
     */
    protected $abandoned = false;

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getKeywords(): array
    {
        return $this->keywords;
    }

    public function getHomepage(): string
    {
        return $this->homepage;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getVersionNormalized(): string
    {
        return $this->versionNormalized;
    }

    public function getLicense(): string
    {
        return $this->license;
    }

    public function getAuthors(): array
    {
        return $this->authors;
    }

    public function getSource(): Source
    {
        return $this->source;
    }

    public function getDist(): Dist
    {
        return $this->dist;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getTime(): string
    {
        return $this->time;
    }

    public function getAutoload(): array
    {
        return $this->autoload;
    }

    public function getExtra(): array
    {
        return $this->extra;
    }

    public function getRequire(): array
    {
        return $this->require;
    }

    public function getRequireDev(): array
    {
        return $this->requireDev;
    }

    public function getConflict(): string
    {
        return $this->conflict;
    }

    public function getProvide(): string
    {
        return $this->provide;
    }

    public function getReplace(): string
    {
        return $this->replace;
    }

    public function getBin(): string
    {
        return $this->bin;
    }

    public function getSuggest(): array
    {
        return $this->suggest;
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
}
