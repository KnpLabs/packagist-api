<?php

namespace Packagist\Api\Result;

class Package extends AbstractResult
{
    /**
     * @var string
     */
    protected $name = null;

    /**
     * @var string
     */
    protected $description = null;

    /**
     * @var string
     */
    protected $time = null;

    /**
     * @var Maintainer
     */
    protected $maintainers = null;

    /**
     * @var Version
     */
    protected $versions = null;

    /**
     * @var string
     */
    protected $type = null;

    /**
     * @var string
     */
    protected $repository = null;

    /**
     * @var Downloads
     */
    protected $downloads = null;

    /**
     * @var string
     */
    protected $favers = null;

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
     * @return Maintainer
     */
    public function getMaintainers()
    {
        return $this->maintainers;
    }

    /**
     * @return Version
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
     * @return Downloads
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
}
