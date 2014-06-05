<?php

namespace Packagist\Api\Result\Package;

use Packagist\Api\Result\AbstractResult;

class Author extends AbstractResult
{
    /**
     * @var string
     */
    protected $name = null;

    /**
     * @var string
     */
    protected $email = null;

    /**
     * @var string
     */
    protected $homepage = null;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getHomepage()
    {
        return $this->homepage;
    }
}
