<?php

namespace Tests\Integration\Feesy\Components\Deletes;

use App\Models\Component;
use App\Feesy\Components\Deletes\TextDelete;
use Tests\TestCase;



class TextDeleteTest extends TestCase
{

	/** @test */
	public function it_delete_text()
	{
		$component = factory(Component::class, 'text')->create();

		$this->seeInDatabase('componentable_texts', [
			'id' => $component->componentable->id,
		]);

		$shapeDelete = app(TextDelete::class);
		$shapeDelete::delete($component->componentable);

		$this->notSeeInDatabase('componentable_texts', [
			'id' => $component->componentable->id,
		]);
	}

}
