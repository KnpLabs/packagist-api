<?php

declare(strict_types=1);

namespace spec\Packagist\Api\Result\Package;

use Packagist\Api\Result\Package\Downloads;
use PhpSpec\ObjectBehavior;

class DownloadsSpec extends ObjectBehavior
{
    public function let()
    {
        $this->fromArray([
            'total'   => 9999999,
            'monthly' => 99999,
            'daily'   => 999,
        ]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Downloads::class);
    }

    public function it_gets_total()
    {
        $this->getTotal()->shouldReturn(9999999);
    }

    public function its_total_is_mutable()
    {
        $this->setTotal(111);
        $this->getTotal()->shouldReturn(111);
    }

    public function it_gets_monthly()
    {
        $this->getMonthly()->shouldReturn(99999);
    }

    public function its_monthly_is_mutable()
    {
        $this->setMonthly(111);
        $this->getMonthly()->shouldReturn(111);
    }

    public function it_gets_daily()
    {
        $this->getDaily()->shouldReturn(999);
    }

    public function its_daily_is_mutable()
    {
        $this->setDaily(111);
        $this->getDaily()->shouldReturn(111);
    }
}
