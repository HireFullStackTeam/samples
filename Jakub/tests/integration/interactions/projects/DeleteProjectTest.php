<?php
namespace Tests\Integration\Interactions\Projects;

use App\Interactions\Projects\DeleteProject;
use App\Models\Project;
use Tests\TestCase;



class DeleteProjectTest extends TestCase
{

	/** @test */
	public function it_deletes_project()
	{
		$project = factory(Project::class)->create();

		$this->seeInDatabase('projects', [
			'id' => $project->id,
		]);

		app(DeleteProject::class)->handle($project);

		$this->notSeeInDatabase('projects', [
			'id' => $project->id,
		]);
	}
}