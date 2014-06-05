<?php

namespace Packagist\Api;

/**
 * Response Exception
 *
 */
class ResponseException extends \Exception
{
    /**
     * @param string $packageName
     *
     * @return \Packagist\Api\ResponseException
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
