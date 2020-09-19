<?php

declare(strict_types=1);

namespace Packagist\Api\Result\Package;

class Dist extends Source
{
    protected string $shasum;

    protected string $type;

    protected string $url;

    protected string $reference;

    public function getShasum(): string
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

    public function getReference(): string
    {
        return $this->reference;
    }
}
