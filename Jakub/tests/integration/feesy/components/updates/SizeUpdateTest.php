<?php

namespace Tests\Integration\Feesy\Components\Updates;

use App\Models\Component;
use App\Feesy\Components\Updates\Partials\SizeUpdate;
use Tests\TestCase;



class SizeUpdateTest extends TestCase
{

	/** @test */
	public function it_updates_component_size()
	{
		$component = factory(Component::class, 'text')->create();

		$height = random_int(10000, 99999);
		$width = random_int(10000, 99999);

		$sizeUpdater = app(SizeUpdate::class);
		$sizeUpdater->update($component, compact('height', 'width'));

		$this->seeInDatabase('components', [
			'id'     => $component->id,
			'height' => $height,
			'width'  => $width,
		]);
	}

}
