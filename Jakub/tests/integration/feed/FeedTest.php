<?php

namespace Tests\Integration\Feed;

use App\Feed\Feed;
use Illuminate\Http\File;
use stdClass;
use Tests\TestCase;



class FeedTest extends TestCase
{

	// TODO prověřit "shipping_weight", "identifier_exists"

	/**
	 * Content of files should be same
	 * Checked with https://business.facebook.com/ads/product_feed/debug
	 *
	 * @var string[]
	 */
	protected $files = [
		'rss'  => 'app/feed/examples/same/facebook/same_1_rss.xml',
		'atom' => 'app/feed/examples/same/facebook/same_1_atom.xml',
		'csv'  => 'app/feed/examples/same/facebook/same_1.csv',
		'tsv'  => 'app/feed/examples/same/facebook/same_1.tsv',
	];

	/**
	 * @var string[]
	 */
	protected $expected = [
		[
			'external_id'  => 'DB_1',
			'title'        => 'Dog Bowl In Blue',
			'price'        => 9.99,
			'link'         => 'http://www.example.com/bowls/db-1.html',
			'image_link'   => 'http://images.example.com/DB_1.png',
			'condition'    => 'new',
			'availability' => 'in stock'
		],
		[
			'external_id'  => 'DB_2',
			'title'        => 'Dog Bowl In Yellow',
			'price'        => 9.99,
			'link'         => 'http://www.example.com/bowls/db-2.html',
			'image_link'   => 'http://images.example.com/DB_2.png',
			'condition'    => 'new',
			'availability' => 'in stock'
		]
	];

	/**
	 * @var Feed
	 */
	protected $feed;



	public function setUp()
	{
		parent::setUp();

		$this->feed = app(Feed::class);
	}



	/** @test */
	public function it_maps_files()
	{
		foreach ($this->files as $extension => $file) {
			$this->assertSame(
				$this->expected, $this->feed->handle(new File(storage_path($file)))->toArray()
			);
		}
	}



	/** @test */
	public function if_fails_on_unsupported_xml_format()
	{
		$this->assertFalse(
			$this->feed->handle(
				new File(storage_path('app/feed/schema/atom.xsd'))
			)
		);
	}



	/** @test */
	public function if_fails_on_unsupported_text_format()
	{
		$this->assertFalse(
			$this->feed->handle(
				new File(storage_path('app/feed/examples/errors/invalid.csv'))
			)
		);
	}



	/**
	 * @test
	 * @expectedException \App\Exceptions\UnsupportedFileExtensionException
	 */
	public function it_throws_exception_when_unsupported_file_type_given()
	{
		$this->assertFalse(
			$this->feed->handle(
				new File('tests/fixtures/images/1.jpg')
			)
		);
	}



	/**
	 * @test
	 * @expectedException \App\Exceptions\Feed\InvalidFileException
	 */
	public function it_throws_exception_when_object_type_is_not_file_or_uploaded_file()
	{
		$this->assertFalse(
			$this->feed->handle(new stdClass)
		);
	}

}
