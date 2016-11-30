<?php

namespace Tests\Acceptance\Factories;

use App\Models\Component;
use App\Models\Componentables\Componentable;
use Tests\TestCase;



class ComponentFactoryTest extends TestCase
{

	/** @test */
	public function it_creates_a_component()
	{
		$component = factory(Component::class)->create();

		$this->seeInDatabase('components', $this->toComponentArray($component));
	}



	/** @test */
	public function it_creates_a_componentable_text()
	{
		$component = factory(Component::class, 'text')->create();

		$this->seeInDatabase('components', $this->toComponentArray($component) + [
				'componentable_type' => Componentable::TEXT,
				'componentable_id'   => $component->componentable_id,
			]);

		$this->seeInDatabase('componentable_texts', [
			'id'      => $component->componentable_id,
			'content' => $component->componentable->content,
		]);
	}



	/** @test */
	public function it_creates_a_componentable_shape()
	{
		$component = factory(Component::class, 'shape')->create();

		$this->seeInDatabase('components', $this->toComponentArray($component) + [
				'componentable_type' => Componentable::SHAPE,
				'componentable_id'   => $component->componentable_id,
			]);

		$this->seeInDatabase('componentable_shapes', [
			'id'    => $component->componentable_id,
			'color' => $component->componentable->color,
		]);
	}



	/**
	 * @param Component $component
	 * @return array
	 */
	protected function toComponentArray(Component $component)
	{
		return [
			'name'       => $component->name,
			'project_id' => $component->project_id,
			'position_x' => $component->position_x,
			'position_y' => $component->position_y,
			'height'     => $component->height,
			'width'      => $component->width,
			'visibility' => $component->visibility,
			'order'      => 0,
		];
	}

}
