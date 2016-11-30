<?php

namespace Tests\Integration;

use App\App;
use App\Models\Componentables\Componentable;
use App\Models\Componentables\Shape;
use App\Models\Componentables\Text;
use App\Support\Dimensions;
use Tests\TestCase;



class ManagesComponentablesTest extends TestCase
{

	/** @test */
	public function it_returns_componentable_text_dimensions()
	{
		$dimensions = App::dimensionsFor(Componentable::TEXT);

		$this->assertInstanceOf(Dimensions::class, $dimensions);
		$this->assertSame(200, $dimensions->width());
		$this->assertSame(100, $dimensions->height());
		$this->assertSame(['width' => 200, 'height' => 100], $dimensions->toArray());

		$dimensions = App::dimensionsFor(Text::class);

		$this->assertInstanceOf(Dimensions::class, $dimensions);
		$this->assertSame(200, $dimensions->width());
		$this->assertSame(100, $dimensions->height());
		$this->assertSame(['width' => 200, 'height' => 100], $dimensions->toArray());
	}



	/** @test */
	public function it_returns_componentable_shape_dimensions()
	{
		$dimensions = App::dimensionsFor(Componentable::SHAPE);

		$this->assertInstanceOf(Dimensions::class, $dimensions);
		$this->assertSame(100, $dimensions->width());
		$this->assertSame(100, $dimensions->height());
		$this->assertSame(['width' => 100, 'height' => 100], $dimensions->toArray());

		$dimensions = App::dimensionsFor(Shape::class);

		$this->assertInstanceOf(Dimensions::class, $dimensions);
		$this->assertSame(100, $dimensions->width());
		$this->assertSame(100, $dimensions->height());
		$this->assertSame(['width' => 100, 'height' => 100], $dimensions->toArray());
	}



	/**
	 * @test
	 * @expectedException \InvalidArgumentException
	 */
	public function it_throws_an_exception_if_invalid_dimensions_given()
	{
		App::dimensionsFor('foo');
	}
}
