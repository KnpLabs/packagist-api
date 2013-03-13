<?php

namespace Packagist\Result\Package;

class Dist extends Source
{
    protected $shasum;

    public function getShasum()
    {
        return $this->shasum;
    }
}
