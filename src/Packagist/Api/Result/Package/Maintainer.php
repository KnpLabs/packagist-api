<?php

declare(strict_types=1);

namespace Packagist\Api\Result\Package;

use Packagist\Api\Result\AbstractResult;

class Maintainer extends AbstractResult
{
    protected string $name = '';

    protected string $email = '';

    protected string $homepage = '';

    protected string $avatarUrl = '';

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getHomepage(): string
    {
        return $this->homepage;
    }

    public function getAvatarUrl(): string
    {
        return $this->avatarUrl;
    }
}
