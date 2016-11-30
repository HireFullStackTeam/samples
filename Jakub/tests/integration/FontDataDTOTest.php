<?php

namespace Tests\Integration;

use App\Interactions\Fonts\DTO\Data;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;



class FontDataDTOTest extends TestCase
{

	/** @test */
	public function it_returns_the_font_information()
	{
		$data = new Data(
			self::uploadedFile()
		);

		$font = $data->fontInformation();

		$this->assertSame('Open Sans', $font->getFontName());
		$this->assertSame('Regular', $font->getFontSubfamily());
		$this->assertSame('Version 1.10', $font->getFontVersion());
		$this->assertSame('TrueType', $font->getFontType());
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
