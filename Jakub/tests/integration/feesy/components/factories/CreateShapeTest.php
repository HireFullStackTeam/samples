<?php

namespace Tests\Integration\Feesy\Components\Factories;

use App\Feesy\Components\Factories\ComponentableFactory;
use App\Models\Component;
use App\Models\Componentables\Componentable;
use App\Models\Shape;
use Tests\TestCase;



class CreateShapeTest extends TestCase
{

	/** @test */
	public function it_creates_a_shape()
	{
		$shape = factory(Shape::class)->create();
		$component = factory(Component::class)->make();

		$color = str_random();

		$data = array_merge(
			$component->toArray(),
			[
				'type'          => Componentable::SHAPE,
				'componentable' => [
					'shape_id' => $shape->id,
					'color'    => $color,
				],
			]
		);

		$componentable = app(ComponentableFactory::class)->create($data['type'], $data['componentable']);

		$this->seeInDatabase('componentable_shapes', [
			'id'       => $componentable->id,
			'shape_id' => $shape->id,
			'color'    => $color,
		]);
	}
}
