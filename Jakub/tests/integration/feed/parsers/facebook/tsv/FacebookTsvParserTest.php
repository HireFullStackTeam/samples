<?php

namespace Tests\Integration\Feed\Parsers\Facebook\Tsv;

use App\Feed\Parsers\Facebook\TSVParser;
use Tests\TestCase;



class FacebookTsvParserTest extends TestCase
{

	/** @test */
	public function it_parses_a_given_tsv_file()
	{
		$parser = new TSVParser();

		// dd(file_put_contents(__DIR__ . '/output.txt', serialize($parser->parse(__DIR__ . '/input.tsv'))));

		$this->assertSame(
			file_get_contents(__DIR__ . '/output.txt'),
			serialize($parser->parse(__DIR__ . '/input.tsv'))
		);
	}
}
