<?php

namespace Packagist\Api\Result;

class Result extends AbstractResult
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
    protected $url;

    /**
     * @var string
     */
    protected $downloads;

    /**
     * @var string
     */
    protected $favers;

    /**
     * @var string
     */
    protected $repository;

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
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
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
     * @return string
     */
    public function getRepository()
    {
        return $this->repository;
    }
}
