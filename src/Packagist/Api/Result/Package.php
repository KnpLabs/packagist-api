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
     * @var Maintainer
     */
    protected $maintainers;

    /**
     * @var Version
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
     * @var Downloads
     */
    protected $downloads;

    /**
     * @var string
     */
    protected $favers;

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
