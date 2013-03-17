<?php

namespace Packagist\Api\Result;

class Result extends AbstractResult
{
    protected $name;
    protected $description;
    protected $url;
    protected $downloads;
    protected $faves;

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getDownloads()
    {
        return $this->downloads;
    }

    public function getFavers()
    {
        return $this->faves;
    }
}
