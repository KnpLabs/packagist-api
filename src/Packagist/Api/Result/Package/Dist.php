<?php

declare(strict_types=1);

namespace Packagist\Api\Result\Package;

use Packagist\Api\Result\AbstractResult;

class Dist extends AbstractResult
{
    protected ?string $shasum = null;

    protected string $type;

    protected string $url;

    protected ?string $reference = null;

    public function getShasum(): ?string
    {
        return $this->shasum;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }
}
