<?php

namespace spec\Packagist\Mock;

use Guzzle\Http\ClientInterface;

abstract class ClientMock implements ClientInterface
{
    public static function getAllEvents()
    {
    }
}
