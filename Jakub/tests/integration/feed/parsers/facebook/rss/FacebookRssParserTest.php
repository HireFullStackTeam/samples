<?php

namespace Tests\Integration\Feed\Parsers\Facebook\Rss;

use App\Feed\Parsers\Facebook\Structure\Channel;
use App\Feed\Parsers\Facebook\Structure\Item;
use App\Feed\Parsers\Facebook\Structure\Rss;
use App\Feed\Parsers\Facebook\Structure\Shipping;
use Sabre\Xml\Service;
use Tests\TestCase;



class FacebookRssParserTest extends TestCase
{

	/** @test */
	public function it_parses_a_given_xml_rss_file()
	{
		$service = new Service;

		$namespace = 'http://base.google.com/ns/1.0';

		$service->elementMap = [
			'rss'                          => Rss::class,
			'channel'                      => Channel::class,
			'item'                         => Item::class,
			'{' . $namespace . '}shipping' => Shipping::class,
		];

		// dd(file_put_contents(__DIR__ . '/output.txt', serialize($service->parse(file_get_contents(__DIR__ . '/input.xml')))));

		$this->assertSame(
			file_get_contents(__DIR__ . '/output.txt'),
			serialize($service->parse(file_get_contents(__DIR__ . '/input.xml')))
		);
	}
}
