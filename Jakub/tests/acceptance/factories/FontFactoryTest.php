<?php

namespace Tests\Acceptance\Factories;

use App\Models\Font;
use File;
use Tests\TestCase;



class FontFactoryTest extends TestCase
{

	/**
	 * @var string
	 */
	protected $directory = 'app/public/fonts/';



	/** @test */
	public function it_creates_a_font()
	{
		$font = factory(Font::class)->create();

		$this->seeInDatabase('fonts', [
			'public'    => $font->public,
			'filename'  => $font->filename,
			'name'      => $font->name,
			'version'   => $font->version,
			'subfamily' => $font->subfamily,
			'type'      => $font->type,
		]);
	}



	/** @test */
	public function it_creates_a_font_with_a_file()
	{
		$font = factory(Font::class)->states('file')->create();

		$this->seeInDatabase('fonts', [
			'public'    => $font->public,
			'filename'  => $font->filename,
			'name'      => $font->name,
			'version'   => $font->version,
			'subfamily' => $font->subfamily,
			'type'      => $font->type,
		]);

		$fullFilePath = storage_path($this->directory) . $font->filename;

		$this->assertFileExists($fullFilePath);

		File::delete($fullFilePath);
	}

}
