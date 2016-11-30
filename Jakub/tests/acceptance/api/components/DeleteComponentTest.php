<?php

namespace Tests\Acceptance\Api\Components;

use App\Models\Component;
use Tests\TestCase;



class DeleteComponentTest extends TestCase
{

	/** @test */
	public function it_deletes_a_text_component()
	{
		$component = factory(Component::class, 'text')
			->create()
			->load('componentable');

		$this->delete('/component/' . $component->id);

		$this->notSeeInDatabase('components', [
			'id' => $component->id,
		]);

		$this->notSeeInDatabase('componentable_texts', [
			'id' => $component->componentable->id,
		]);
	}



	/** @test */
	public function it_deletes_a_shape_component()
	{
		$component = factory(Component::class, 'shape')
			->create()
			->load('componentable');

		$this->delete('/component/' . $component->id);

		$this->notSeeInDatabase('components', [
			'id' => $component->id,
		]);

		$this->notSeeInDatabase('componentable_shapes', [
			'id' => $component->componentable->id,
		]);
	}
}
