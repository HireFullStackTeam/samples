<?php

namespace Tests\Acceptance\Api\Components\Componentables;


use App\Models\Component;
use Tests\TestCase;



class UpdateShapeComponentTest extends TestCase
{

	/** @test */
	public function it_updates_shape_component()
	{
		$component = factory(Component::class, 'shape')->create();

		$color = str_random(60);

		$this->patch('/component/' . $component->id, [
			'componentable' => [
				'color' => $color,
			],
		]);

		$this->seeInDatabase('componentable_shapes', [
			'id'    => $component->componentable->id,
			'color' => $color,
		]);
	}
}
