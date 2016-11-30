<?php

namespace Tests\Integration\Feed\Parsers\Facebook\Atom;

use App\Feed\Parsers\Facebook\Structure\Atom;
use App\Feed\Parsers\Facebook\Structure\Item;
use App\Feed\Parsers\Facebook\Structure\Shipping;
use Sabre\Xml\Service;
use Tests\TestCase;



class FacebookAtomParserTest extends TestCase
{

	/** @test */
	public function it_parses_a_given_xml_atom_file()
	{
		$service = new Service;

		$atom = 'http://www.w3.org/2005/Atom';
		$g = 'http://base.google.com/ns/1.0';

		$service->elementMap = [
			'{' . $atom . '}feed'  => Atom::class,
			'{' . $atom . '}entry' => Item::class,
			'{' . $g . '}shipping' => Shipping::class,
		];

		// dd(file_put_contents(__DIR__ . '/output.txt', serialize($service->parse(file_get_contents(__DIR__ . '/input.xml')))));

		$this->assertSame(
			file_get_contents(__DIR__ . '/output.txt'),
			serialize($service->parse(file_get_contents(__DIR__ . '/input.xml')))
		);
	}
}
