<?php

namespace Tests\Integration\Feesy\Components\Deletes;

use App\Models\Component;
use App\Feesy\Components\Deletes\ShapeDelete;
use Tests\TestCase;

class ShapeDeleteTest extends TestCase
{

	/** @test */
	public function it_delete_shape()
	{
		$component = factory(Component::class, 'shape')->create();

		$this->seeInDatabase('componentable_shapes', [
			'id' => $component->componentable->id,
		]);

		$shapeDelete = app(ShapeDelete::class);
		$shapeDelete::delete($component->componentable);

		$this->notSeeInDatabase('componentable_shapes', [
			'id' => $component->componentable->id,
		]);
	}

}
