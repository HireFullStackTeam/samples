<?php

namespace Tests\Unit;

use App\App;
use App\Models\Componentables\Componentable;
use App\Models\Componentables\Image;
use App\Models\Componentables\Shape;
use App\Models\Componentables\Text;
use PHPUnit_Framework_TestCase;



class ComponentableMorphMapTest extends PHPUnit_Framework_TestCase
{

	/** @test */
	public function it_tests_componentable_polymorphic_array()
	{
		$this->assertSame([
			Componentable::TEXT  => Text::class,
			Componentable::SHAPE => Shape::class,
			Componentable::IMAGE => Image::class,
		], App::componentablesMorphMap());
	}



	/** @test */
	public function it_returns_correct_componentable_type_of_class()
	{
		$this->assertSame(Componentable::TEXT, App::componentableTypeOf(Text::class));
		$this->assertSame(Componentable::SHAPE, App::componentableTypeOf(Shape::class));
		$this->assertSame(Componentable::IMAGE, App::componentableTypeOf(Image::class));
	}



	/** @test */
	public function it_returns_correct_componentable_class_by_type()
	{
		$this->assertSame(Text::class, App::componentableClassBy(Componentable::TEXT));
		$this->assertSame(Shape::class, App::componentableClassBy(Componentable::SHAPE));
		$this->assertSame(Image::class, App::componentableClassBy(Componentable::IMAGE));
	}



	/**
	 * @expectedException \InvalidArgumentException
	 * @test
	 */
	public function it_throws_an_exception_when_invalid_componentable_class_given()
	{
		App::componentableTypeOf('some_invalid_class');
	}



	/**
	 * @expectedException \InvalidArgumentException
	 * @test
	 */
	public function it_throws_an_exception_when_invalid_componentable_type_given()
	{
		App::componentableClassBy('some_invalid_type');
	}
}
