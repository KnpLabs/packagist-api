<?php

namespace Packagist\Api\Result;

class Result extends AbstractResult
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
    protected $url = null;
    /**
     * @var string
     */
    protected $downloads = null;
    /**
     * @var string
     */
    protected $faves = null;

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
        return $this->faves;
    }
}
