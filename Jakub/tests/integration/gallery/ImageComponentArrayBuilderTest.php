<?php

namespace Tests\Integration\Gallery;

use App\Gallery\Imageable;
use App\Gallery\ImageComponentArrayBuilder;
use App\Models\Componentables\Componentable;
use App\Models\Gallery\Image;
use Tests\TestCase;



class ImageComponentArrayBuilderTest extends TestCase
{

	/** @test */
	public function it_returns_component_image_array()
	{
		$width = $height = 100;

		$image = factory(Image::class)->make();
		$imageable = (new Imageable(''))->setDimensions($width, $height);

		$expected = [
			'project_id'    => $image->project_id,
			'type'          => Componentable::IMAGE,
			'visibility'    => true,
			'componentable' => [
				'image_id' => null,
			],
			'position_x'    => ($image->project->type->width - $width) / 2,
			'position_y'    => ($image->project->type->height - $height) / 2,
			'width'         => $width,
			'height'        => $height,
		];

		$this->assertSame(
			$expected, ImageComponentArrayBuilder::build($image, $imageable)
		);
	}

}
