<?php

namespace Tests\Unit;

use App\Interactions\Fonts\DTO\Data;
use App\Models\Font;
use App\Models\Project;
use Illuminate\Http\UploadedFile;
use PHPUnit_Framework_TestCase;



class FontDataDTOTest extends PHPUnit_Framework_TestCase
{

	/** @test */
	public function it_checks_the_file_and_the_file_hashname()
	{
		$project = $this->prophesize(Project::class);
		$file = self::uploadedFile();

		$data = new Data(
			$file, $project->reveal()
		);

		$this->assertSame(
			md5_file($file->getRealPath()) . '.' . $file->guessExtension(), $data->filename()
		);

		$this->assertSame($file, $data->file());
	}



	/** @test */
	public function it_gets_an_assigned_project()
	{
		$project = $this->prophesize(Project::class)->reveal();

		$data = new Data(
			self::uploadedFile(), $project
		);

		$this->assertSame($project, $data->project());
	}



	/** @test */
	public function it_check_if_the_font_is_public()
	{
		$data = new Data(
			self::uploadedFile()
		);

		$this->assertTrue($data->isPublic());
	}



	/** @test */
	public function it_check_if_the_font_is_not_public()
	{
		$project = $this->prophesize(Project::class)->reveal();

		$data = new Data(
			self::uploadedFile(), $project
		);

		$this->assertFalse($data->isPublic());
	}



	/** @test */
	public function it_assigns_a_font()
	{
		$data = new Data(
			self::uploadedFile()
		);

		$font = new Font();

		$data->assignFont($font);

		$this->assertSame($font, $data->font());
	}



	/**
	 * @return UploadedFile
	 */
	protected static function uploadedFile()
	{
		$path = 'tests/fixtures/fonts/test-font.ttf';
		$filename = str_slug(str_random());
		$mime = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $path);

		return new UploadedFile($path, $filename, $mime, null, null, true);
	}

}
