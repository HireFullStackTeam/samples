<?php

namespace Tests\Unit\Gallery\Support;

use App\Gallery\Support\ResponseCollection;
use App\Models\Component;
use App\Models\Gallery\Image;
use PHPUnit_Framework_TestCase;



class ResponseCollectionTest extends PHPUnit_Framework_TestCase
{

	/** @test */
	public function it_adds_a_image()
	{
		$responseCollection = new ResponseCollection;

		$image = $this->prophesize(Image::class)->reveal();

		$responseCollection->addImage($image);

		$this->assertSame($image, $responseCollection->images()->first());
	}



	/** @test */
	public function it_adds_a_component()
	{
		$responseCollection = new ResponseCollection;

		$component = $this->prophesize(Component::class)->reveal();

		$responseCollection->addComponent($component);

		$this->assertSame($component, $responseCollection->components()->first());
	}



	/** @test */
	public function it_retrieves_all_images()
	{
		$responseCollection = new ResponseCollection;

		$numberOfImages = 3;

		$images = [];

		for ($i = 1; $i <= $numberOfImages; $i++) {
			$image = $this->prophesize(Image::class)->reveal();
			$responseCollection->addImage($image);
			$images[] = $image;
		}

		$this->assertSame(
			$numberOfImages,
			$responseCollection->images()->count()
		);

		foreach ($responseCollection->images() as $key => $image) {
			$this->assertSame($images[$key], $image);
		}
	}



	/** @test */
	public function it_retrieves_all_components()
	{
		$responseCollection = new ResponseCollection;

		$numberOfComponents = 3;

		$components = [];

		for ($i = 1; $i <= $numberOfComponents; $i++) {
			$component = $this->prophesize(Component::class)->reveal();
			$responseCollection->addComponent($component);
			$components[] = $component;
		}

		$this->assertSame(
			$numberOfComponents,
			$responseCollection->components()->count()
		);

		foreach ($responseCollection->components() as $key => $component) {
			$this->assertSame($components[$key], $component);
		}
	}

}