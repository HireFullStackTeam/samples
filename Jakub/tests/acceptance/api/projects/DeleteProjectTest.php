<?php

namespace Tests\Acceptance\Api\Projects;


use App\Models\Project;
use Tests\TestCase;



class DeleteProjectsTest extends TestCase
{

	/** @test */
	public function it_deletes_project()
	{
		$project = factory(Project::class)->create();

		$this->delete('/project/' . $project->id);

		$this->notSeeInDatabase('projects', [
			'id' => $project->id,
		]);
	}

}
