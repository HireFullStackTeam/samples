<?php

namespace Tests\Acceptance\Api\Shapes;

use App\Models\Shape;
use Tests\TestCase;



class RetrieveShapesTest extends TestCase
{

	/** @test */
	public function it_retrieves_all_shapes()
	{
		factory(Shape::class)->create();

		$request = $this->get('shape');

		$request->seeJsonStructure([
			'data' => [
				'*' =>
					[
						'id',
						'content',
					],
			],
		]);
	}
}
