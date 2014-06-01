<?php

namespace Packagist\Api\Result\Package;

class Dist extends Source
{
    /**
     * @var string
     */
    protected $shasum = null;
    /**
     * @var string
     */
    protected $type = null;
    /**
     * @var string
     */
    protected $url = null;
    /**
     * @var string
     */
    protected $reference = null;

    /**
     * @return string
     */
    public function getShasum()
    {
        return $this->shasum;
    }
    /* (non-PHPdoc)
     * @see \Packagist\Api\Result\Package\Source::getType()
     */
    public function getType()
    {
        return $this->type;
    }
    /* (non-PHPdoc)
     * @see \Packagist\Api\Result\Package\Source::getUrl()
     */
    public function getUrl()
    {
        return $this->url;
    }
    /* (non-PHPdoc)
     * @see \Packagist\Api\Result\Package\Source::getReference()
     */
    public function getReference()
    {
        return $this->reference;
    }
}
