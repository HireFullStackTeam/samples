<?php

namespace Tests\Integration\Interactions\Projects;

use App\Events\ProjectCreated;
use App\Interactions\Projects\CreateProject;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;



class CreateProjectTest extends TestCase
{

	/** @test */
	public function it_creates_a_project()
	{
		Event::fake();

		$user = factory(User::class)->create();

		/** @var CreateProject $interaction */
		$interaction = app(CreateProject::class);

		$name = 'my project name';

		$project = $interaction->handle([
			'name' => $name,
			'type' => 1,
		], $user);

		$this->assertTrue($project->exists);
		$this->assertSame($name, $project->name);

		$this->seeInDatabase('projects', [
			'id'      => $project->id,
			'name'    => $name,
			'type_id' => $project->type->id,
		]);

		Event::assertFired(ProjectCreated::class, function (ProjectCreated $event) use ($project) {
			return $event->project()->id === $project->id;
		});
	}



	/** @test */
	public function it_fails_on_validation_if_no_data()
	{
		$user = factory(User::class)->create();

		/** @var CreateProject $interaction */
		$interaction = app(CreateProject::class);

		$validator = $interaction->validator([], $user);

		$this->assertTrue($validator->fails());
	}



	/** @test */
	public function it_fails_when_project_type_does_not_exist()
	{
		Event::fake();

		$user = factory(User::class)->create();

		/** @var CreateProject $interaction */
		$interaction = app(CreateProject::class);

		$validator = $interaction->validator([
			'name' => 'foo',
			'type' => 0,
		], $user);

		$this->assertTrue($validator->fails());
		$this->assertTrue($validator->errors()->has('type'));
	}
}
