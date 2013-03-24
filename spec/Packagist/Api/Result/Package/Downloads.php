<?php

namespace spec\Packagist\Api\Result\Package;

use PHPSpec2\ObjectBehavior;

class Downloads extends ObjectBehavior
{
    function let()
    {
        $this->fromArray(array(
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

    function it_gets_monthly()
    {
        $this->getMonthly()->shouldReturn(99999);
    }

    function it_gets_daily()
    {
        $this->getDaily()->shouldReturn(999);
    }
}
