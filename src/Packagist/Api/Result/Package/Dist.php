<?php

namespace Packagist\Api\Result\Package;

class Dist extends Source
{
    /**
     * @var string
     */
    protected $shasum = null;

    /**
     * @return string
     */
    public function getShasum()
    {
        return $this->shasum;
    }
}
