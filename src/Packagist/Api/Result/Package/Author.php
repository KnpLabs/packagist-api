<?php

namespace Packagist\Api\Result\Package;

use Packagist\Api\Result\AbstractResult;

class Author extends Maintainer
{
	protected $role;

	public function getRole()
	{
		return $this->role;
	}

}
