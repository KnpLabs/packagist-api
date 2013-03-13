<?php

namespace Packagist\Result\Package;

use Packagist\Result\AbstractResult;

class Author extends AbstractResult
{
    protected $name;
    protected $email;
    protected $homepage;

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getHomepage()
    {
        return $this->homepage;
    }
}
