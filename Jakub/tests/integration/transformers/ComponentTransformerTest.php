<?php

namespace Tests\Integration\Transformers;

use App\Models\Component;
use App\Transformers\ComponentTransformer;
use Illuminate\Support\Arr;
use Tests\TestCase;



class ComponentTransformerTest extends TestCase
{

	/**
	 * @var string[]
	 */
	protected $exclude = [
		'project_id',
		'updated_at',
		'created_at',
		'componentable_id'
	];



	/** @test */
	public function it_transforms_component()
	{
		$component = factory(Component::class, 'text')->create();

		$expected = array_merge($component->toArray(), [
			'order'              => 0,
			'componentable_type' => $component->componentable_type,
			'componentable'      => [
				'content' => $component->componentable->content,
				'state'   => $component->componentable->state
			]
		]);

		$this->assertEquals(
			Arr::except($expected, $this->exclude), (new ComponentTransformer)->transform($component)
		);
	}
}
