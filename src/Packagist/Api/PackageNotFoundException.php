<?php

declare(strict_types=1);

namespace Packagist\Api;

use InvalidArgumentException;

/**
 * Thrown when a requested package was not found in the Packagist API.
 */
class PackageNotFoundException extends InvalidArgumentException
{
}
