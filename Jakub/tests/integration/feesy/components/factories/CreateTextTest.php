<?php

namespace Tests\Integration\Feesy\Components\Factories;

use App\Feesy\Components\Factories\ComponentableFactory;
use App\Models\Component;
use App\Models\Componentables\Componentable;
use Tests\TestCase;



class CreateTextTest extends TestCase
{

	/** @test */
	public function it_creates_text()
	{
		$component = factory(Component::class)->make();

		$content = str_random(60);

		$data = array_merge(
			$component->toArray(),
			[
				'type'          => Componentable::TEXT,
				'componentable' => [
					'content' => $content,
				],
			]
		);

		$componentable = app(ComponentableFactory::class)->create($data['type'], $data['componentable']);

		$this->seeInDatabase('componentable_texts', [
			'id'      => $componentable->id,
			'content' => $content,
		]);
	}
}
