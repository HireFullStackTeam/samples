<?php

namespace Tests\Acceptance\Api\Projects;


use App\Models\Project;
use Tests\TestCase;



class UpdateProjectsTest extends TestCase
{

	/** @test */
	public function it_updates_projects_name()
	{
		$project = factory(Project::class)->create();

		$name = str_random(64);

		$request = $this->patch('/project/' . $project->id, [
			'name' => $name,
			'type' => $project->type->id,
		]);

		$request->seeJson([
			'data' => [
				'id'         => $project->id,
				'name'       => $name,
				'type'       => [
					'data' => [
						'name'   => $project->type->name,
						'width'  => $project->type->width,
						'height' => $project->type->height,
					],
				],
				'components' => [
					'data' => [],
				],
			],
		]);
	}

}
