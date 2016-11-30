<?php

namespace Tests\Integration\Feesy\Components\Updates;

use App\Models\Component;
use App\Feesy\Components\Updates\Partials\VisibilityUpdate;
use Tests\TestCase;



class VisibilityUpdateTest extends TestCase
{

	/** @test */
	public function it_updates_component_visibility()
	{
		$component = factory(Component::class, 'text')->create([
			'visibility' => true,
		]);

		$visibility = false;

		$sizeUpdater = app(VisibilityUpdate::class);
		$sizeUpdater->update($component, compact('visibility'));

		$this->seeInDatabase('components', [
			'id'         => $component->id,
			'visibility' => $visibility,
		]);
	}

}
