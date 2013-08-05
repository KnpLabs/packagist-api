<?php

namespace Packagist\Api\Result\Package;

use Packagist\Api\Result\AbstractResult;

class Version extends AbstractResult
{
    protected $name;
    protected $description;
    protected $keywords;
    protected $homepage;
    protected $version;
    protected $versionNormalized;
    protected $license;
    protected $authors;
    protected $source;
    protected $dist;
    protected $time;
    protected $autoload;
    protected $extra;
    protected $require;
    protected $requireDev;
    protected $conflict;
    protected $provide;
    protected $replace;
    protected $bin;

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getKeywords()
    {
        return $this->keywords;
    }

    public function getHomepage()
    {
        return $this->homepage;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function getVersionNormalized()
    {
        return $this->versionNormalized;
    }

    public function getLicense()
    {
        return $this->license;
    }

    public function getAuthors()
    {
        return $this->authors;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function getDist()
    {
        return $this->dist;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function getAutoload()
    {
        return $this->autoload;
    }

    public function getExtra()
    {
        return $this->extra;
    }

    public function getRequire()
    {
        return $this->require;
    }

    public function getRequireDev()
    {
        return $this->requireDev;
    }

    public function getConflict()
    {
        return $this->conflict;
    }

    public function getProvide()
    {
        return $this->provide;
    }

    public function getReplace()
    {
        return $this->replace;
    }

    public function getBin()
    {
        return $this->bin;
    }
}
