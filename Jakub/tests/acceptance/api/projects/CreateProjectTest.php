<?php

namespace Tests\Acceptance\Api\Projects;


use App\Models\Project;
use Tests\TestCase;



class CreateProjectsTest extends TestCase
{

	/** @test */
	public function it_creates_project()
	{
		$project = factory(Project::class)->make();

		$request = $this->post('/project', [
			'name' => $project->name,
			'type' => $project->type_id,
		]);

		$request->seeJson([
			'data' => [
				'id'         => $request->decodeResponseJson()['data']['id'],
				'name'       => $project->name,
				'type'       => [
					"data" => [
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
