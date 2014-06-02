<?php

namespace Packagist\Api;

class PackagistApiResponseException extends \Exception
{
    /**
     * @param string $packageName
     * @return \Packagist\Api\PackagistApiResponseException
     */
    public static function packageDoesNotExist($packageName)
    {
        return new self(
            sprintf(
                'Package with name "%s" does not exist',
                $packageName
            )
        );
    }
}
