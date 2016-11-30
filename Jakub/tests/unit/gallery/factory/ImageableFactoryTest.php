<?php

namespace Tests\Unit\Gallery\Factory;

use App\Gallery\Factory\ImageableFactory;
use App\Gallery\Imageable;
use App\Gallery\Support\Dimensions;
use PHPUnit_Framework_TestCase;



class ImageableFactoryTest extends PHPUnit_Framework_TestCase
{

	/** @test */
	public function it_builds_image_imageable()
	{
		$path = 'fake_path/test.jpeg';

		$dimensions = new Dimensions(10, 20);

		/** @var Imageable $imageable */
		$imageable = (new ImageableFactory)->build($path, $dimensions->width, $dimensions->height);

		$this->assertSame($path, $imageable->path());
		$this->assertSame($dimensions->width, $imageable->dimensions()->width);
		$this->assertSame($dimensions->height, $imageable->dimensions()->height);

		$this->assertSame(null, $imageable->position());
	}
}
