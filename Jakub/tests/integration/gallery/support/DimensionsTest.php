<?php

namespace Tests\Integration\Gallery\Support;

use App\App;
use App\Contracts\Gallery\FileProcessable;
use App\Gallery\Support\Dimensions;
use File;
use stdClass;
use Tests\TestCase;



class DimensionsTest extends TestCase
{

	/**
	 * Image size over 2000x2000px
	 *
	 * @var string
	 */
	protected $bigImageSourcePath = 'tests/fixtures/images/big_1_3749x2500px.jpg';

	/**
	 * Image size under 2000x2000px
	 *
	 * @var string
	 */
	protected $smallImageSourcePath = 'tests/fixtures/images/small_1_1024x698px.jpg';

	/**
	 * @var stdClass
	 */
	protected $image;



	public function setUp()
	{
		parent::setUp();

		$this->image = self::createDummyImage();
	}

	/** @test */
	public function it_resize_image_bigger_than_2000x2000()
	{
		File::copy($this->bigImageSourcePath, $this->image->path);

		Dimensions::resize($this->image->name);

		list($width, $height) = getimagesize($this->image->path);

		$this->assertLessThanOrEqual(2000, $width);
		$this->assertLessThanOrEqual(2000, $height);

		File::delete($this->image->path);
	}



	/** @test */
	public function it_not_resize_image_smaller_than_2000x2000()
	{
		File::copy($this->smallImageSourcePath, $this->image->path);

		Dimensions::resize($this->image->name);

		list($width, $height) = getimagesize($this->image->path);

		$this->assertLessThanOrEqual(1024, $width);
		$this->assertLessThanOrEqual(698, $height);

		File::delete($this->image->path);
	}



	/** @test */
	public function it_resize_image_to_set_dimensions_size_should_be_smaller_than_set_values()
	{
		File::copy($this->smallImageSourcePath, $this->image->path);

		$width = 100;
		$height = 100;

		Dimensions::resize($this->image->name, $width, $height);

		list($resizeImageWidth, $resizeImageHeight) = getimagesize($this->image->path);

		$this->assertLessThanOrEqual($width, $resizeImageWidth);
		$this->assertLessThanOrEqual($height, $resizeImageHeight);

		File::delete($this->image->path);
	}



	/**
	 * @return stdClass
	 */
	protected static function createDummyImage()
	{
		return new class
		{
			public $name;
			public $path;

			public function __construct()
			{
				$this->name = str_slug(str_random(64)) . '.jpg';
				$this->path = App::fileSystemStoragePath() . $this->name;
			}
		};
	}
}
