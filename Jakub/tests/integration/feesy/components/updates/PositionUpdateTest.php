<?php

namespace Tests\Integration\Feesy\Components\Updates;

use App\Models\Component;
use App\Feesy\Components\Updates\Partials\PositionUpdate;
use Tests\TestCase;



class PositionUpdateTest extends TestCase
{

	/** @test */
	public function it_updates_component_position()
	{
		$component = factory(Component::class, 'text')->create();

		$position_x = random_int(10000, 99999);
		$position_y = random_int(10000, 99999);

		$sizeUpdater = app(PositionUpdate::class);
		$sizeUpdater->update($component, compact('position_x', 'position_y'));

		$this->seeInDatabase('components', [
			'id'         => $component->id,
			'position_x' => $position_x,
			'position_y' => $position_y,
		]);
	}

}
