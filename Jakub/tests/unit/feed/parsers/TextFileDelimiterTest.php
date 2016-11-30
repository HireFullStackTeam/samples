<?php

namespace Tests\Unit\Feed\Parsers;

use App\Feed\Parsers\TextFileDelimiter;
use PHPUnit_Framework_TestCase;



class TextFileDelimiterTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var string
	 */
	protected $directory = 'tests/fixtures/feed/string';

	/**
	 * @var string[]
	 */
	protected $delimiters = [
		'csv' => ',',
		'tsv' => "\t"
	];



	/** @test */
	public function it_guesses_delimiters()
	{
		foreach ($this->delimiters as $extension => $delimiter) {
			$this->assertSame(
				$this->delimiters[$extension], TextFileDelimiter::resolve($this->filePath($extension))
			);
		}
	}



	/** @test */
	public function it_guesses_delimiters_via_fluent_interface()
	{
		foreach ($this->delimiters as $extension => $delimiter) {
			$this->assertTrue(
				TextFileDelimiter::check($this->filePath($extension))->against($this->delimiters[$extension])
			);
		}
	}



	/** @test */
	public function it_returns_empty_array_when_text_file_with_unsupported_delimiter_given()
	{
		$this->assertFalse(TextFileDelimiter::resolve($this->filePath('csv', 'invalid')));
	}



	/** @test */
	public function it_sets_number_of_lines()
	{
		$extension = 'csv';

		$this->assertTrue(
			TextFileDelimiter::check($this->filePath($extension))
				->checkLines(1)
				->against($this->delimiters[$extension])
		);
	}



	/**
	 * @param  string $extension
	 * @param string $fileName
	 * @return string
	 */
	protected function filePath($extension, $fileName = 'input')
	{
		return sprintf('%s/' . $fileName . '.%s', $this->directory, $extension);
	}
}
