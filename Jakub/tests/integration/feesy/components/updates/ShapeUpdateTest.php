<?php

namespace Tests\Integration\Feesy\Components\Updates;


use App\Feesy\Components\Updates\Partials\ShapeUpdate;
use App\Models\Component;
use Tests\TestCase;



class ShapeUpdateTest extends TestCase
{

	/** @test */
	public function it_updates_a_component_color()
	{
		$component = factory(Component::class, 'shape')->create();

		$color = [
			'componentable' => [
				'color' => str_random(10),
			],
		];

		$shapeUpdater = app(ShapeUpdate::class);
		$shapeUpdater->update($component, $color);

		$this->seeInDatabase('componentable_shapes', [
			'id'    => $component->componentable->id,
			'color' => $color,
		]);
	}

}
