<?php

namespace Packagist\Api\Result\Package;

use Packagist\Api\Result\AbstractResult;

class Source extends AbstractResult
{
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
