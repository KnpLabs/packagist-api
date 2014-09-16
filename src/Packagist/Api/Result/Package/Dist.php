<?php

namespace Packagist\Api\Result\Package;

class Dist extends Source
{
    /**
     * @var string
     */
    protected $shasum;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $reference;

    /**
     * @return string
     */
    public function getShasum()
    {
        return $this->shasum;
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
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }
}
