<?php

namespace Tests\Acceptance\Factories;

use App\Models\Font;
use App\Models\Project;
use Tests\TestCase;



class ProjectFactoryTest extends TestCase
{

	/** @test */
	public function it_creates_a_project()
	{
		$project = factory(Project::class)->create();

		$this->seeInDatabase('projects', [
			'id'      => $project->id,
			'name'    => $project->name,
			'type_id' => $project->type->id,
		]);
	}



	/** @test */
	public function it_creates_a_project_with_fonts()
	{
		/** @var Project $project */
		$project = factory(Project::class)->create();

		$fonts = factory(Font::class, 3)->create()->each(function (Font $font) use ($project) {
			$project->fonts()->attach($font);
		});

		$this->assertCount(3, $project->fonts);
		$this->assertSame($fonts->first()->id, $project->fonts()->first()->id);
	}
}
