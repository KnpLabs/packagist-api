<?php

namespace Packagist\Api\Result\Package;

use Packagist\Api\Result\AbstractResult;

class Downloads extends AbstractResult
{
    /**
     * @var integer
     */
    protected $total = null;
    /**
     * @var integer
     */
    protected $monthly = null;
    /**
     * @var integer
     */
    protected $daily = null;

    /**
     * @param integer $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }
    /**
     * @param integer $monthly
     */
    public function setMonthly($monthly)
    {
        $this->monthly = $monthly;
    }
    /**
     * @param integer $daily
     */
    public function setDaily($daily)
    {
        $this->daily = $daily;
    }

    /**
     * @return number
     */
    public function getTotal()
    {
    	return $this->total;
    }
    /**
     * @return number
     */
    public function getMonthly()
    {
    	return $this->monthly;
    }
    /**
     * @return number
     */
    public function getDaily()
    {
    	return $this->daily;
    }
}
