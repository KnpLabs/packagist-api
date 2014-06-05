<?php

namespace Packagist\Api\Result\Package;

use Packagist\Api\Result\AbstractResult;

class Version extends AbstractResult
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
    protected $keywords = null;

    /**
     * @var string
     */
    protected $homepage = null;

    /**
     * @var string
     */
    protected $version = null;

    /**
     * @var string
     */
    protected $versionNormalized = null;

    /**
     * @var string
     */
    protected $license = null;

    /**
     * @var array
     */
    protected $authors = null;

    /**
     * @var Source
     */
    protected $source = null;

    /**
     * @var Dist
     */
    protected $dist = null;

    /**
     * @var string
     */
    protected $type = null;

    /**
     * @var string
     */
    protected $time = null;

    /**
     * @var array
     */
    protected $autoload = null;

    /**
     * @var array
     */
    protected $extra = null;

    /**
     * @var array
     */
    protected $require = null;

    /**
     * @var array
     */
    protected $requireDev = null;

    /**
     * @var string
     */
    protected $conflict = null;

    /**
     * @var string
     */
    protected $provide = null;

    /**
     * @var string
     */
    protected $replace = null;

    /**
     * @var string
     */
    protected $bin = null;

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
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @return string
     */
    public function getHomepage()
    {
        return $this->homepage;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return string
     */
    public function getVersionNormalized()
    {
        return $this->versionNormalized;
    }

    /**
     * @return string
     */
    public function getLicense()
    {
        return $this->license;
    }

    /**
     * @return array
     */
    public function getAuthors()
    {
        return $this->authors;
    }

    /**
     * @return \Packagist\Api\Result\Package\Source
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return \Packagist\Api\Result\Package\Dist
     */
    public function getDist()
    {
        return $this->dist;
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
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @return array
     */
    public function getAutoload()
    {
        return $this->autoload;
    }

    /**
     * @return array
     */
    public function getExtra()
    {
        return $this->extra;
    }

    /**
     * @return array
     */
    public function getRequire()
    {
        return $this->require;
    }

    /**
     * @return array
     */
    public function getRequireDev()
    {
        return $this->requireDev;
    }

    /**
     * @return string
     */
    public function getConflict()
    {
        return $this->conflict;
    }

    /**
     * @return string
     */
    public function getProvide()
    {
        return $this->provide;
    }

    /**
     * @return string
     */
    public function getReplace()
    {
        return $this->replace;
    }

    /**
     * @return string
     */
    public function getBin()
    {
        return $this->bin;
    }
}
