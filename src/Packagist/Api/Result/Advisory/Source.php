<?php

namespace Packagist\Api\Result\Advisory;

use Packagist\Api\Result\AbstractResult;

class Source extends AbstractResult
{
    protected string $name;

    protected string $remoteId;

    public function getName(): string
    {
        return $this->name;
    }

    public function getRemoteId(): string
    {
        return $this->remoteId;
    }
}
