<?php

namespace Tests\Acceptance\Api\Fonts;

use App\Models\Font;
use Tests\TestCase;



class RetrieveFontsTest extends TestCase
{

	/** @test */
	public function it_retrieves_all_fonts()
	{
		factory(Font::class)->create();

		$this->get('/font')
			->seeJsonStructure([
				'data' => [
					'*' => [
						'id',
						'public',
						'filename',
						'name',
						'version',
						'subfamily',
						'type',
					],
				],
			]);
	}

}
