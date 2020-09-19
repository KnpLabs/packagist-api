<?php

declare(strict_types=1);

namespace Packagist\Api\Result\Package;

class Author extends Maintainer
{
    protected string $role;

    public function getRole(): string
    {
        return $this->role;
    }
}
