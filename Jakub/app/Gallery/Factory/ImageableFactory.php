<?php

namespace App\Gallery\Factory;

use App\Contracts\Gallery\Factory\ImageableFactory as Contract;
use App\Gallery\Imageable;



class ImageableFactory implements Contract
{

	/**
	 * {@inheritdoc}
	 */
	public function build($path, $width, $height)
	{
		return (new Imageable($path))
			->setDimensions($width, $height);
	}
}
