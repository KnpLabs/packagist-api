<?php

namespace Packagist\Api\Result\Package;

use Packagist\Api\Result\AbstractResult;

class Downloads extends AbstractResult
{
    protected $total;
    protected $monthly;
    protected $daily;

    public function getTotal()
    {
        return $this->total;
    }

    public function getMonthly()
    {
        return $this->monthly;
    }

    public function getDaily()
    {
        return $this->daily;
    }
}
