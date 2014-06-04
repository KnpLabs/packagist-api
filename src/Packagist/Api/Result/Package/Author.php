<?php

namespace Packagist\Api\Result\Package;

class Author extends Maintainer
{
    protected $role;

    public function getRole()
    {
        return $this->role;
    }

}
