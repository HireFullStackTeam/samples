<?php

namespace Tests\Unit\Gallery\Support;


use App\Gallery\Support\Dimensions;
use PHPUnit_Framework_TestCase;



class DimensionsTest extends PHPUnit_Framework_TestCase
{

	/** @test */
	public function it_sets_values_throw_construct_and_retrieves_attributes_values()
	{
		$width = 10;
		$height = 20;

		$dimensions = new Dimensions($width, $height);

		$this->assertSame($width, $dimensions->width);
		$this->assertSame($height, $dimensions->height);
	}



	/** @test */
	public function it_sets_and_retrieves_width()
	{
		$width = 100;

		$dimensions = new Dimensions(0, 0);
		$dimensions->setWidth($width);

		$this->assertSame($width, $dimensions->width);
	}



	/** @test */
	public function it_sets_and_retrieves_height()
	{
		$height = 100;

		$dimensions = new Dimensions(0, 0);
		$dimensions->setHeight($height);

		$this->assertSame($height, $dimensions->height);
	}

}
