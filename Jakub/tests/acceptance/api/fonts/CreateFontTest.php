<?php

namespace Tests\Acceptance\Api\Fonts;

use File;
use Tests\Support\UploadedFile;
use Tests\TestCase;



class CreateFontTest extends TestCase
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
	public function it_creates_a_font()
	{
		$request = $this->post('font', [
			'file' => $this->file,
		]);

		$this->seeInDatabase('fonts', [
			'id' => $request->decodeResponseJson()['data']['id'],
			'filename' => $request->decodeResponseJson()['data']['filename'],
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

		$fullFilePath = storage_path($this->directory) . $request->decodeResponseJson()['data']['filename'];

		$this->assertFileExists($fullFilePath);

		File::delete($fullFilePath);
	}
}
