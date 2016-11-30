<?php

namespace Tests\Acceptance\Api\Fonts;

use App\Models\Font;
use App\Models\Project;
use Tests\TestCase;



class RetrieveProjectFontsTest extends TestCase
{

	/** @test */
	public function it_retrieves_all_project_fonts()
	{
		$project = factory(Project::class)->create();
		$this->createsFonts($project, 4);

		$this->get('/project/' . $project->id . '/fonts')
			->seeJsonStructure([
				'data' => [
					'*' => [
						'id',
						'public',
						'filename',
						'name',
						'version',
						'subfamily',
						'type',
					],
				],
			]);
	}



	/** @test */
	public function it_retrieves_one_project_font_after_one_project_was_created()
	{
		$project = factory(Project::class)->create();
		$font = $this->createsFonts($project, 1)[0];

		$this->get('/project/' . $project->id . '/fonts')->seeJsonEquals([
			'data' => [[
				'id'        => $font->id,
				'public'    => $font->public,
				'filename'  => $font->filename,
				'name'      => $font->name,
				'version'   => $font->version,
				'subfamily' => $font->subfamily,
				'type'      => $font->type,
			]],
		]);

	}



	/**
	 * @param Project $project
	 * @param int $amount
	 * @return Font[]
	 */
	protected function createsFonts(Project $project, $amount)
	{
		$fonts = [];

		for ($i = 1; $i <= $amount; $i++) {
			$font = factory(Font::class)->create();
			$font->projects()->attach($project);
			$fonts[] = $font;
		}

		return $fonts;
	}

}
