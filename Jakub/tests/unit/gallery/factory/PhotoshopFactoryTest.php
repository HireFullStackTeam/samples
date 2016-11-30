<?php

namespace Tests\Unit\Gallery\Factory;

use App\Gallery\Factory\PhotoshopFactory;
use App\Gallery\Imageable;
use App\Gallery\Support\Dimensions;
use App\Gallery\Support\Position;
use PHPUnit_Framework_TestCase;



class PhotoshopFactoryTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var string
	 */
	protected $path = 'fake_path/test.jpeg';



	/** @test */
	public function it_builds_photoshop_imageable()
	{
		$position = new Position(10, 20);
		$dimensions = new Dimensions(10, 20);

		/** @var Imageable $imageable */
		$imageable = (new PhotoshopFactory)->build($this->path, [
			'width'  => $dimensions->width,
			'height' => $dimensions->height,
			'x'      => $position->x,
			'y'      => $position->y,
		]);

		$this->assertSame($this->path, $imageable->path());
		$this->assertSame($dimensions->width, $imageable->dimensions()->width);
		$this->assertSame($dimensions->height, $imageable->dimensions()->height);

		$this->assertSame($position->x, $imageable->position()->x);
		$this->assertSame($position->y, $imageable->position()->y);
	}
}
