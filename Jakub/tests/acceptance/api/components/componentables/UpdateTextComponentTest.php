<?php

namespace Tests\Acceptance\Api\Components\Componentables;

use App\Models\Component;
use Tests\TestCase;



class UpdateTextComponentTest extends TestCase
{

	/** @test */
	public function it_updates_text_component()
	{
		$component = factory(Component::class, 'text')->create();

		$content = str_random(60);
		$state = str_random(60);

		$this->patch('/component/' . $component->id, [
			'componentable' => [
				'content' => $content,
				'state'   => $state
			],
		]);

		$this->seeInDatabase('componentable_texts', [
			'id'      => $component->componentable->id,
			'content' => $content,
			'state'   => $state,
		]);
	}
}
