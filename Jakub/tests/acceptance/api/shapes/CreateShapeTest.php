<?php

namespace Tests\Acceptance\Api\Shapes;

use App\Models\Shape;
use Tests\TestCase;



class CreateShapesTest extends TestCase
{

	/** @test */
	public function it_creates_a_shape()
	{
		$shape = factory(Shape::class)->make();

		$request = $this->post('shape', $shape->toArray());

		$request->seeJsonContains([
			'data' => [
				'id'      => $request->decodeResponseJson()['data']['id'],
				'name'    => $shape->name,
				'content' => $shape->content
			],
		]);
	}
}
