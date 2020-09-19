<?php

declare(strict_types=1);

namespace Packagist\Api\Result;

class Result extends AbstractResult
{
    protected string $name;

    protected string $description;

    protected string $url;

    protected int $downloads;

    protected int $favers;

    protected string $repository;

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getDownloads(): int
    {
        return $this->downloads;
    }

    public function getFavers(): int
    {
        return $this->favers;
    }

    public function getRepository(): string
    {
        return $this->repository;
    }
}
