<?php

namespace Tests\Integration\Feesy\Components\Updates;


use App\Models\Component;
use App\Feesy\Components\Updates\Partials\TextUpdate;
use Tests\TestCase;



class TextUpdateTest extends TestCase
{

	/** @test */
	public function it_updates_component_text_content()
	{
		$component = factory(Component::class, 'text')->create();

		$content = [
			'componentable' =>
				[
					'content' => str_random(),
				],
		];

		$updater = app(TextUpdate::class);
		$updater->update($component, $content);

		$this->seeInDatabase('componentable_texts', [
			'id'      => $component->componentable->id,
			'content' => $content,
		]);
	}

}
