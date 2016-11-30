<?php

namespace App\Contracts\Gallery\Factory;

use App\Gallery\Imageable;



interface ImageableFactory
{

	/**
	 * @param string $path
	 * @param int $width
	 * @param int $height
	 * @return Imageable
	 */
	public function build($path, $width, $height);
}
