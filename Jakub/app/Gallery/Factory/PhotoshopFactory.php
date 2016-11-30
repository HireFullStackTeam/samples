<?php

namespace App\Gallery\Factory;

use App\Contracts\Gallery\Factory\PhotoshopFactory as Contract;
use App\Gallery\Imageable;



class PhotoshopFactory implements Contract
{

	/**
	 * {@inheritdoc}
	 */
	public function build($path, array $layer)
	{
		return (new Imageable($path))
			->setPosition($layer['x'], $layer['y'])
			->setDimensions($layer['width'], $layer['height']);
	}
}
