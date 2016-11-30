<?php

namespace Tests\Unit\Feesy;

use App\Feesy\Components\Factories\HasArrayName;
use App\Feesy\Components\Factories\ShapeFactory;
use App\Feesy\Components\Factories\TextFactory;
use PHPUnit_Framework_TestCase;
use stdClass;



class HasArrayNameTraitTest extends PHPUnit_Framework_TestCase
{

	/** @test */
	public function it_returns_correct_componentables_array_name()
	{
		$this->assertSame('text', TextFactory::getArrayName());
		$this->assertSame('shape', ShapeFactory::getArrayName());

		$class = self::class();
		
		$this->assertSame('custom_array_name', $class::getArrayName());
	}



	/**
	 * @return stdClass
	 */
	protected static function class()
	{
		return new class
		{

			use HasArrayName;

			protected static $arrayName = 'custom_array_name';
		};
	}
}
