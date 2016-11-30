<?php

namespace Tests\Acceptance\Api\Types;

use Tests\TestCase;



class RetrieveTypesTest extends TestCase
{

	/** @test */
	public function it_retrieves_a_types()
	{
		$this->get('/type')
			->seeJsonStructure([
				'data' => [
					'*' => [
						'name',
						'width',
						'height',
					],
				],
			]);
	}



	/** @test */
	public function it_retrieves_the_facebook_type()
	{
		$this->get('/type')
			->seeJson([
				'name'   => 'Facebook',
				'width'  => 1200,
				'height' => 628,
			]);
	}
}
