<?php

namespace Packagist\Api\Result\Package;

class Dist extends Source
{
    protected $shasum;
    protected $type;
    protected $url;
    protected $reference;

    public function getShasum()
    {
        return $this->shasum;
    }

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
