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
     * @var string
     */
    protected $authors = null;
    /**
     * @var string
     */
    protected $source = null;
    /**
     * @var string
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
     * @var string
     */
    protected $autoload = null;
    /**
     * @var string
     */
    protected $extra = null;
    /**
     * @var string
     */
    protected $require = null;
    /**
     * @var string
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
     * @return string
     */
    public function getAuthors()
    {
        return $this->authors;
    }
    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }
    /**
     * @return string
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
     * @return string
     */
    public function getAutoload()
    {
        return $this->autoload;
    }
    /**
     * @return string
     */
    public function getExtra()
    {
        return $this->extra;
    }
    /**
     * @return string
     */
    public function getRequire()
    {
        return $this->require;
    }
    /**
     * @return string
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
