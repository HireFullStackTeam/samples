<?php

namespace App\Contracts\Gallery\Factory;

use App\Gallery\Imageable;



interface PhotoshopFactory
{

	/**
	 * @param string $path
	 * @param array $layer
	 * @return Imageable
	 */
	public function build($path, array $layer);
}
