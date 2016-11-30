<?php

namespace Tests\Integration\Repositories;

use App\Models\Project;
use App\Models\Project\Type;
use App\Models\User;
use App\Repositories\ProjectRepository;
use Tests\TestCase;



class ProjectRepositoryTest extends TestCase
{

	/**
	 * @var ProjectRepository
	 */
	protected $projects;



	public function setUp()
	{
		parent::setUp();

		$this->projects = new ProjectRepository;
	}



	/** @test */
	public function it_creates_a_new_project_for_given_name()
	{
		$user = factory(User::class)->create();

		$name = str_random(60);

		$this->projects->create($user, Type::find(1), $name);

		$this->seeInDatabase('projects', [
			'name' => $name,
		]);
	}



	/** @test */
	public function it_updates_a_project_name()
	{
		$project = factory(Project::class)->create();

		$name = str_random(60);

		$this->projects->update($project, compact('name'));

		$this->seeInDatabase('projects', [
			'id'   => $project->id,
			'name' => $name,
		]);
	}



	/** @test */
	public function it_updates_project_type()
	{
		$project = factory(Project::class)->create();

		$type = factory(Type::class)->create();

		$this->projects->update($project, [
			'type' => $type->id,
		]);

		$this->seeInDatabase('projects', [
			'id'      => $project->id,
			'type_id' => $type->id,
		]);
	}
}
