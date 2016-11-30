<?php

namespace Tests\Acceptance\Api\Fonts;

use App\Models\Font;
use App\Models\Project;
use Tests\TestCase;



class DeleteProjectFontsTest extends TestCase
{

	/**
	 * @var string
	 */
	protected $directory = 'app/public/fonts/';



	/** @test */
	public function it_deletes_one_project_font()
	{
		$project = factory(Project::class)->create();

		$font = factory(Font::class)->states('file')->create([
			'public' => false,
		]);

		$font->projects()->attach($project);

		$this->seeInDatabase('project_has_fonts', [
			'font_id'    => $font->id,
			'project_id' => $project->id,
		]);

		$this->delete('/project/' . $project->id . '/fonts/' . $font->id);

		$this->seeInDatabase('projects', [
			'id' => $project->id,
		]);

		$this->notSeeInDatabase('fonts', [
			'id' => $font->id,
		]);

		$this->notSeeInDatabase('project_has_fonts', [
			'font_id'    => $font->id,
			'project_id' => $project->id,
		]);

		$this->assertFileNotExists(storage_path($this->directory) . $font->filename);
	}
}
