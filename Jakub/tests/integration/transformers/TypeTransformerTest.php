<?php

namespace Tests\Integration\Transformers;

use App\Models\Project\Type;
use App\Transformers\TypeTransformer;
use Illuminate\Support\Arr;
use Tests\TestCase;



class TypeTransformerTest extends TestCase
{

	/**
	 * @var string[]
	 */
	protected $exclude = [
		'id',
		'updated_at',
		'created_at',
	];



	/** @test */
	public function it_transforms_type()
	{
		$type = factory(Type::class)->create();

		$this->assertSame(
			Arr::except($type->toArray(), $this->exclude), (new TypeTransformer)->transform($type)
		);
	}
}

