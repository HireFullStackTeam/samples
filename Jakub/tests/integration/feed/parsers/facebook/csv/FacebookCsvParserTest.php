<?php

namespace Tests\Integration\Feed\Parsers\Facebook\Csv;


use App\Feed\Parsers\Facebook\CSVParser;
use Tests\TestCase;



class FacebookCsvParserTest extends TestCase
{

	/** @test */
	public function it_parses_a_given_csv_file()
	{
		$parser = new CSVParser();

		// dd(file_put_contents(__DIR__ . '/output.txt', serialize($parser->parse(__DIR__ . '/input.csv'))));

		$this->assertSame(
			file_get_contents(__DIR__ . '/output.txt'),
			serialize($parser->parse(__DIR__ . '/input.csv'))
		);
	}
}
