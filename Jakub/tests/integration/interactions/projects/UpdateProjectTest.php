<?php
namespace Tests\Integration\Interactions\Projects;

use App\Interactions\Projects\UpdateProject;
use App\Models\Project;
use Tests\TestCase;



class UpdateProjectTest extends TestCase
{

	/** @test */
	public function it_updates_project()
	{
		$project = factory(Project::class)->create();

		$name = str_random(40);

		$data = [
			'name' => $name,
		];

		app(UpdateProject::class)->handle($project, $data);

		$this->seeInDatabase('projects', [
			'id'      => $project->id,
			'name'    => $name,
		]);

	}

	/** @test */
	public function it_fail_on_update_validation_if_no_data()
	{
		$project = factory(Project::class)->create();

		/** @var UpdateProject $interaction */
		$interaction = app(UpdateProject::class);

		$validator = $interaction->validator($project,[]);

		$this->assertTrue($validator->fails());
	}

}