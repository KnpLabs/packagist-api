<?php

namespace Packagist\Api;

class Filter
{
    /**
     * The type of package
     *
     * @var string
     */
    private $type = null;
    /**
     * The name of github account
     *
     * @var string
     */
    private $vendor = null;
    /**
     * Tags of packages
     *
     * @var array
     */
    private $tags = array();

    /**
     * Add tag
     * @param string $tagName
     * @return \Packagist\Api\Filter
     */
    public function addTag($tagName)
    {
        $this->tags[] = $tagName;
        return $this;
    }
    /**
     * Set name of github account
     * @param string $vendorName
     * @return \Packagist\Api\Filter
     */
    public function setVendor($vendorName)
    {
        $this->vendor = $vendorName;
        return $this;
    }
    /**
     * Set type of package
     * @param string $type
     * @return \Packagist\Api\Filter
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }
    /**
     * @return string
     */
    public function getVendor()
    {
        return $this->vendor;
    }
    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
    /**
     * Reset tags
     * @return \Packagist\Api\Filter
     */
    public function resetTags()
    {
        $this->tags = array();
        return $this;
    }

    /**
     * @return string
     */
    public function getHttpQuery()
    {
        $httpQuery = array();
        if (empty($this->tags) === false) {
            foreach ($this->tags as $tag) {
                $httpQuery[] =  'tags[]=' . urlencode($tag);
            }
        }
        if ($this->vendor !== null) {
            $httpQuery[] = 'vendor=' . urlencode($this->vendor);
        }
        if ($this->type !== null) {
            $httpQuery[] = 'type=' . urlencode($this->type);
        }

        return implode("&", $httpQuery);
    }
}
