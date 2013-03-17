<?php

namespace Packagist\Api\Result\Package;

use Packagist\Api\Result\AbstractResult;

class Source extends AbstractResult
{
    protected $type;
    protected $url;
    protected $reference;

    public function getType()
    {
        return $this->type;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getReference()
    {
        return $this->reference;
    }
}
