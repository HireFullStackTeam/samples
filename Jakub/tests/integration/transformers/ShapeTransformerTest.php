<?php

namespace Tests\Integration\Transformers;

use App\Models\Componentables\Shape;
use App\Transformers\Componentables\ShapeTransformer;
use Illuminate\Support\Arr;
use Tests\TestCase;



class ShapeTransformerTest extends TestCase
{

	/**
	 * @var string[]
	 */
	protected $keys = ['shape_id', 'color', 'content'];



	/** @test */
	public function it_transforms_the_shape()
	{
		$shape = factory(Shape::class)->create();

		$this->assertEquals(
			Arr::only($shape->toArray() + ['content' => $shape->content], $this->keys), (new ShapeTransformer)->transform($shape)
		);
	}
}
