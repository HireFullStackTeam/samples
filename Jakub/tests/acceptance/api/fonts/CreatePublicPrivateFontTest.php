<?php

namespace Tests\Acceptance\Api\Fonts;

use App\Models\Project;
use File;
use Tests\Support\UploadedFile;
use Tests\TestCase;



class CreatePublicPrivateFontTest extends TestCase
{

	/**
	 * @var string
	 */
	protected $font = 'tests/fixtures/fonts/test-font.ttf';

	/**
	 * @var string
	 */
	protected $directory = 'app/public/fonts/';

	/**
	 * @var UploadedFile
	 */
	protected $file;



	public function setUp()
	{
		parent::setUp();

		$this->file = UploadedFile::makeFrom($this->font);
	}



	/** @test */
	public function it_creates_a_public_font()
	{
		$request = $this->post('font', [
			'file' => $this->file,
		]);

		$request->seeJsonStructure([
			'data' => [
				'id',
				'public',
				'filename',
				'name',
				'version',
				'subfamily',
				'type',
			],
		]);

		$this->seeInDatabase('fonts', [
			'id'     => $request->decodeResponseJson()['data']['id'],
			'public' => true,
		]);

		File::delete(storage_path($this->directory) . $request->decodeResponseJson()['data']['filename']);
	}



	/** @test */
	public function it_creates_a_private_font()
	{
		$project = factory(Project::class)->create();

		$request = $this->post('font', [
			'file'       => $this->file,
			'project_id' => $project->id,
		]);

		$request->seeJsonStructure([
			'data' => [
				'id',
				'public',
				'filename',
				'name',
				'version',
				'subfamily',
				'type',
			],
		]);

		$this->seeInDatabase('fonts', [
			'id'     => $request->decodeResponseJson()['data']['id'],
			'public' => false,
		]);

		$this->seeInDatabase('project_has_fonts', [
			'font_id'    => $request->decodeResponseJson()['data']['id'],
			'project_id' => $project->id,
		]);

		$this->assertFileExists(
			storage_path($this->directory) . $request->decodeResponseJson()['data']['filename']
		);

		File::delete(storage_path($this->directory) . $request->decodeResponseJson()['data']['filename']);
	}
}
