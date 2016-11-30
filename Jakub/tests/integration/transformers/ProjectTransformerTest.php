<?php

namespace Tests\Integration\Transformers;

use App\Models\Project;
use App\Transformers\ProjectTransformer;
use Illuminate\Support\Arr;
use Tests\TestCase;



class ProjectTransformerTest extends TestCase
{

	/**
	 * @var string[]
	 */
	protected $keys = ['id', 'name'];



	/** @test */
	public function it_transforms_project()
	{
		$project = factory(Project::class)->create();

		$this->assertEquals(
			Arr::only($project->toArray(), $this->keys), (new ProjectTransformer)->transform($project)
		);
	}
}
