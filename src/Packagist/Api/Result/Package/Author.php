<?php

namespace Packagist\Api\Result\Package;

class Author extends Maintainer
{
    /**
     * @var string
     */
    protected $role;

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

}
