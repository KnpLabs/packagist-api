<?php

namespace Packagist\Api\Result;

class Package extends AbstractResult
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $time;

    /**
     * @var Package\Maintainer[]
     */
    protected $maintainers;

    /**
     * @var Package\Version[]
     */
    protected $versions;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $repository;

    /**
     * @var Package\Downloads
     */
    protected $downloads;

    /**
     * @var string
     */
    protected $favers;

    /**
     * @var bool|string
     */
    protected $abandoned = false;

    /**
     * @var integer
     */
    protected $suggesters = 0;

    /**
     * @var integer
     */
    protected $dependents = 0;

    /**
     * @var integer
     */
    protected $githubStars = 0;

    /**
     * @var integer
     */
    protected $githubForks = 0;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @return Package\Maintainer[]
     */
    public function getMaintainers()
    {
        return $this->maintainers;
    }

    /**
     * @return Package\Version[]
     */
    public function getVersions()
    {
        return $this->versions;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @return Package\Downloads
     */
    public function getDownloads()
    {
        return $this->downloads;
    }

    /**
     * @return string
     */
    public function getFavers()
    {
        return $this->favers;
    }

    /**
     * @return bool
     */
    public function isAbandoned()
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

    /**
     * @return integer
     */
    public function getSuggesters()
    {
        return $this->suggesters;
    }

    /**
     * @return integer
     */
    public function getDependents()
    {
        return $this->dependents;
    }

    /**
     * @return integer
     */
    public function getGithubStars()
    {
        return $this->githubStars;
    }

    /**
     * @return integer
     */
    public function getGithubForks()
    {
        return $this->githubForks;
    }
}
