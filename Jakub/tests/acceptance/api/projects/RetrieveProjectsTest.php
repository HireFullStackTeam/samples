<?php

namespace Tests\Acceptance\Api\Projects;

use App\Models\Project;
use Tests\TestCase;



class RetrieveProjectsTest extends TestCase
{

	/** @test */
	public function it_retrieves_all_projects()
	{
		factory(Project::class, 2)->create();

		$this->get('/project')
			->seeJsonStructure([
				'data' => [
					'*' => [
						'id',
						'name',
						'components' => [
							'data' => [],
						],
					],
				],
			]);
	}



	/** @test */
	public function it_retrieves_a_project()
	{
		$project = factory(Project::class)->create();

		$this->get('/project/' . $project->id)
			->seeJson([
				'data' => [
					'id'         => $project->id,
					'name'       => $project->name,
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
