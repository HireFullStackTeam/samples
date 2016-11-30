<?php

namespace Tests\Unit\Feesy\Components;

use App\Feesy\Components\Deletes\ShapeDelete;
use App\Models\Componentables\Componentable;
use PHPUnit_Framework_TestCase;
use Prophecy\Prophecy\ObjectProphecy;



class ShapeDeleteTest extends PHPUnit_Framework_TestCase
{

	/** @test */
	public function it_deletes_a_shape()
	{
		$componentable = $this->mockComponentable()->reveal();

		$this->assertTrue(ShapeDelete::delete($componentable));
	}



	/**
	 * @return ObjectProphecy|Componentable
	 */
	protected function mockComponentable()
	{
		$componentable = $this->prophesize(Componentable::class);

		$componentable
			->delete()
			->shouldBeCalled()
			->willReturn(true);

		return $componentable;
	}
}
