<?php

namespace Tests\Acceptance\Api\Components;

use App\App;
use App\Models\Component;
use App\Models\Componentables\Componentable;
use App\Models\Componentables\Shape;
use App\Models\Componentables\Text;
use App\Models\Project;
use App\Repositories\ComponentRepository;
use Tests\TestCase;



class CreateComponentTest extends TestCase
{

	/** @test */
	public function it_creates_a_text_component()
	{
		$component = factory(Component::class)->make();

		$componentable = [
			'content' => str_random(50),
			'state'   => str_random(50)
		];

		$order = $this->order($component);

		$request = $this->post('/component', $component->toArray() + [
				'type'          => Componentable::TEXT,
				'componentable' => $componentable
			]);

		$request->seeJson([
			'data' => [
				'id'                 => $request->decodeResponseJson()['data']['id'],
				'name'               => 'Text 1',
				'visibility'         => $component->visibility,
				'position_x'         => floor(($component->project->type->width - App::dimensionsFor(Text::class)->width()) / 2),
				'position_y'         => floor(($component->project->type->height - App::dimensionsFor(Text::class)->height()) / 2),
				'height'             => App::dimensionsFor(Text::class)->height(),
				'width'              => App::dimensionsFor(Text::class)->width(),
				'order'              => $order,
				'componentable_type' => Componentable::TEXT,
				'componentable'      => $componentable
			],
		]);

		$this->seeInDatabase('componentable_texts', $componentable);

		$this->seeInDatabase('components', [
			'name'       => 'Text 1',
			'project_id' => $component->project_id,
			'position_x' => floor(($component->project->type->width - App::dimensionsFor(Text::class)->width()) / 2),
			'position_y' => floor(($component->project->type->height - App::dimensionsFor(Text::class)->height()) / 2),
			'height'     => App::dimensionsFor(Text::class)->height(),
			'width'      => App::dimensionsFor(Text::class)->width(),
			'visibility' => $component->visibility,
			'order'      => $order,
		]);
	}



	/** @test */
	public function it_creates_a_shape_component()
	{
		$component = factory(Component::class)->make();
		$shape = factory(\App\Models\Shape::class)->create();

		$color = str_random(60);

		$order = $this->order($component);

		$request = $this->post('/component', $component->toArray() + [
				'type'          => Componentable::SHAPE,
				'componentable' => [
					'shape_id' => $shape->id,
					'color'    => $color,
					'content'  => $shape->content
				],
			]);

		$request->seeJsonEquals([
			'data' => [
				'id'                 => $request->decodeResponseJson()['data']['id'],
				'name'               => 'Shape 1',
				'visibility'         => $component->visibility,
				'position_x'         => floor(($component->project->type->width - App::dimensionsFor(Shape::class)->width()) / 2),
				'position_y'         => floor(($component->project->type->height - App::dimensionsFor(Shape::class)->height()) / 2),
				'height'             => App::dimensionsFor(Shape::class)->height(),
				'width'              => App::dimensionsFor(Shape::class)->width(),
				'order'              => $order,
				'componentable_type' => Componentable::SHAPE,
				'componentable'      => [
					'shape_id' => $shape->id,
					'color'    => $color,
					'content'  => $shape->content
				],
			],
		]);

		$this->seeInDatabase('componentable_shapes', [
			'shape_id' => $shape->id,
			'color'    => $color
		]);

		$this->seeInDatabase('components', [
			'name'       => 'Shape 1',
			'project_id' => $component->project_id,
			'position_x' => floor(($component->project->type->width - App::dimensionsFor(Shape::class)->width()) / 2),
			'position_y' => floor(($component->project->type->height - App::dimensionsFor(Shape::class)->height()) / 2),
			'height'     => App::dimensionsFor(Shape::class)->height(),
			'width'      => App::dimensionsFor(Shape::class)->width(),
			'visibility' => $component->visibility,
			'order'      => $order,
		]);
	}



	/**
	 * @param Component $component
	 * @return int
	 */
	protected function order(Component $component)
	{
		return (new ComponentRepository(new Project()))->maxOrder($component->project);
	}
}
