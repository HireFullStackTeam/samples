<?php

namespace Tests\Unit\Gallery;

use App\Gallery\Imageable;
use PHPUnit_Framework_TestCase;



class ImageableTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var string
	 */
	protected $path = 'path/fake.txt';



	/** @test */
	public function it_sets_path_via_construct()
	{
		$imageable = new Imageable($this->path);

		$this->assertSame($this->path, $imageable->path());
	}



	/** @test */
	public function it_sets_position()
	{
		$x = 10;
		$y = 20;

		$imageable = new Imageable($this->path);
		$imageable->setPosition($x, $y);

		$this->assertSame($x, $imageable->position()->x);
		$this->assertSame($y, $imageable->position()->y);
	}



	/** @test */
	public function it_sets_dimensions()
	{
		$width = 100;
		$height = 200;

		$imageable = new Imageable($this->path);
		$imageable->setDimensions($width, $height);

		$this->assertSame($width, $imageable->dimensions()->width);
		$this->assertSame($height, $imageable->dimensions()->height);
	}

}
