<?php

namespace Tests\Unit\Feed\Factory;

use App\Feed\Factory\ReaderFactory;
use PHPUnit_Framework_TestCase;



class ReaderFactoryTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var string
	 */
	protected $directory = 'tests/fixtures/feed/string/';

	/**
	 * @var string[]
	 */
	protected $delimiters = [
		'csv' => [
			'delimiter' => ',',
			'count'     => 22
		],
		'tsv' => [
			'delimiter' => "\t",
			'count'     => 31
		],
	];



	/** @test */
	public function it_creates_reader()
	{
		$factory = new ReaderFactory();

		foreach ($this->delimiters as $extension => $data) {

			$reader = $factory->createFromPath(
				sprintf('%s/input.%s', $this->directory, $extension),
				$data['delimiter']
			);

			$this->assertCount($data['count'], $reader->fetchOne());

			$this->assertSame(
				$data['delimiter'], $reader->getDelimiter()
			);
		}
	}
}