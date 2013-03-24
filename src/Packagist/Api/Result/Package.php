<?php

namespace Packagist\Api\Result;

class Package extends AbstractResult
{
    protected $name;
    protected $description;
    protected $time;
    protected $maintainers;
    protected $versions;
    protected $type;
    protected $repository;
    protected $downloads;
    protected $favers;

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function getMaintainers()
    {
        return $this->maintainers;
    }

    public function getVersions()
    {
        return $this->versions;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getRepository()
    {
        return $this->repository;
    }

    public function getDownloads()
    {
        return $this->downloads;
    }

    public function getFavers()
    {
        return $this->favers;
    }
}
