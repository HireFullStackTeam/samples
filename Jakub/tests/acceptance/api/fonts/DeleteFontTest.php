<?php

namespace Tests\Acceptance\Api\Fonts;


use App\Models\Font;
use Tests\TestCase;



class DeleteFontTest extends TestCase
{

	/**
	 * @var string
	 */
	protected $directory = 'app/public/fonts/';



	/** @test */
	public function it_deletes_a_font()
	{
		$font = factory(Font::class)->states('file')->create();

		$this->delete('/font/' . $font->id);

		$this->notSeeInDatabase('fonts', [
			'id' => $font->id,
		]);

		$this->assertFileNotExists($this->path($font));
	}



	/**
	 * @param Font $font
	 * @return string
	 */
	protected function path($font)
	{
		return storage_path($this->directory) . $font->filename;
	}
}
