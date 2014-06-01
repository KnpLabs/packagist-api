<?php

namespace spec\Packagist\Api\Result\Package;

use PhpSpec\ObjectBehavior;

class DownloadsSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(array(
            'total'   => 9999999,
            'monthly' => 99999,
            'daily'   => 999,
        ));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Packagist\Api\Result\Package\Downloads');
    }

    function it_gets_total()
    {
        $this->getTotal()->shouldReturn(9999999);
    }

    function its_total_is_mutable()
    {
        $this->setTotal(111);
        $this->getTotal()->shouldReturn(111);
    }

    function it_gets_monthly()
    {
        $this->getMonthly()->shouldReturn(99999);
    }

    function its_monthly_is_mutable()
    {
        $this->setMonthly(111);
        $this->getMonthly()->shouldReturn(111);
    }

    function it_gets_daily()
    {
        $this->getDaily()->shouldReturn(999);
    }

    function its_daily_is_mutable()
    {
        $this->setDaily(111);
        $this->getDaily()->shouldReturn(111);
    }
}
