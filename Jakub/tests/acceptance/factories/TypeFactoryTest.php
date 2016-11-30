<?php

namespace Tests\Acceptance\Factories;

use App\Models\Project\Type;
use Tests\TestCase;



class TypeFactoryTest extends TestCase
{

	/** @test */
	public function it_creates_a_type()
	{
		$type = factory(Type::class)->create();

		$this->seeInDatabase('project_types', [
			'id'     => $type->id,
			'name'   => $type->name,
			'height' => $type->height,
			'width'  => $type->width,
		]);
	}
}
