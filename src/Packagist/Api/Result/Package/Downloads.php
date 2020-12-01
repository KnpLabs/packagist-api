<?php

declare(strict_types=1);

namespace Packagist\Api\Result\Package;

use Packagist\Api\Result\AbstractResult;

class Downloads extends AbstractResult
{
    protected int $total;

    protected int $monthly;

    protected int $daily;

    public function setTotal(int $total): self
    {
        $this->total = $total;
        return $this;
    }

    public function setMonthly(int $monthly): self
    {
        $this->monthly = $monthly;
        return $this;
    }

    public function setDaily(int $daily): self
    {
        $this->daily = $daily;
        return $this;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getMonthly(): int
    {
        return $this->monthly;
    }

    public function getDaily(): int
    {
        return $this->daily;
    }
}
