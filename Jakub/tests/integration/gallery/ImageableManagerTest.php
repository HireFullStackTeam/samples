<?php

namespace Tests\Integration\Gallery;

use App\Gallery\ImageableManager;
use App\Gallery\Processors\ImageProcessor;
use App\Gallery\Processors\PhotoshopProcessor;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Tests\TestCase;



class ImageableManagerTest extends TestCase
{

	/**
	 * @var ImageableManager
	 */
	protected $manager;

	/**
	 * @var string
	 */
	protected $directories = [
		'jpeg' => 'tests/fixtures/images/',
		'psd'  => 'tests/fixtures/images/psds/',
		'pdf'  => 'tests/fixtures/pdfs/',
	];



	public function setUp()
	{
		parent::setUp();

		$this->manager = app(ImageableManager::class);
	}



	/** @test */
	public function it_returns_photoshop_processor()
	{
		$processor = $this->manager->driver($this->file('psd'));

		$this->assertInstanceOf(PhotoshopProcessor::class, $processor);
	}



	/** @test */
	public function it_returns_image_processor()
	{
		$processor = $this->manager->driver($this->file('jpeg'));

		$this->assertInstanceOf(ImageProcessor::class, $processor);
	}



	/**
	 * @expectedException \App\Exceptions\UnsupportedFileExtensionException
	 * @test
	 */
	public function it_fails_on_not_supported_file_extension()
	{
		$this->manager->driver($this->file('pdf'));
	}



	/**
	 * @param string $type
	 * @return UploadedFile
	 */
	protected function file($type)
	{
		$path = $this->path($type);

		return new UploadedFile(
			$path, str_slug(str_random()), finfo_file(finfo_open(FILEINFO_MIME_TYPE), $path), null, null, true
		);
	}



	/**
	 * @param string $type
	 * @return string
	 */
	protected function directory($type)
	{
		return $this->directories[$type];
	}



	/**
	 * @param string $type
	 * @return string
	 */
	protected function path($type)
	{
		return base_path(
			$this->directory($type) . $this->filename($type)
		);
	}



	/**
	 * @param string $type
	 * @return string
	 */
	protected function filename($type)
	{
		$filename = '1.' . $type;

		if (Str::contains($type, 'jpeg')) {
			$filename = Str::replaceFirst('jpeg', 'jpg', $filename);
		}

		return $filename;
	}
}
