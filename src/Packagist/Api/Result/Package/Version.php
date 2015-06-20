<?php

namespace Packagist\Api\Result\Package;

use Packagist\Api\Result\AbstractResult;

class Version extends AbstractResult
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
    protected $keywords;

    /**
     * @var string
     */
    protected $homepage;

    /**
     * @var string
     */
    protected $version;

    /**
     * @var string
     */
    protected $versionNormalized;

    /**
     * @var string
     */
    protected $license;

    /**
     * @var array
     */
    protected $authors;

    /**
     * @var Source
     */
    protected $source;

    /**
     * @var Dist
     */
    protected $dist;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $time;

    /**
     * @var array
     */
    protected $autoload;

    /**
     * @var array
     */
    protected $extra;

    /**
     * @var array
     */
    protected $require;

    /**
     * @var array
     */
    protected $requireDev;

    /**
     * @var string
     */
    protected $conflict;

    /**
     * @var string
     */
    protected $provide;

    /**
     * @var string
     */
    protected $replace;

    /**
     * @var string
     */
    protected $bin;

    /**
     * @var array
     */
    protected $suggest;

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
     * @return Source
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return Dist
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

    /**
     * @return array
     */
    public function getSuggest()
    {
        return $this->suggest;
    }
}
