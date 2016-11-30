<?php

namespace Tests\Acceptance\Api\Components\Order;


use App\App;
use App\Models\Component;
use App\Models\Componentables\Componentable;
use App\Models\Componentables\Text;
use Tests\TestCase;



class CreateComponentOrderTest extends TestCase
{

	/** @test */
	public function it_creates_components_and_checks_for_correct_incrementing_order()
	{
		$component = factory(Component::class)->make();

		$componentable = [
			'content' => str_random(50),
			'state'   => str_random(50)
		];

		$order = 3;

		for ($i = 1; $i <= $order; $i++) {
			$request = $this->post('/component', $component->toArray() + [
					'type'          => Componentable::TEXT,
					'componentable' => $componentable
				]);
		}

		$request->seeJson([
			'data' => [
				'id'                 => $request->decodeResponseJson()['data']['id'],
				'name'               => 'Text 3',
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
	}

}
