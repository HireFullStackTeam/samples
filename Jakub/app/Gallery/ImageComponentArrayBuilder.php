<?php

namespace App\Gallery;

use App\Models\Componentables\Componentable;
use App\Models\Gallery\Image;
use App\Models\Project\Type;



class ImageComponentArrayBuilder
{

	/**
	 * @param Image $image
	 * @param Imageable $imageable
	 * @return array
	 */
	public static function build(Image $image, Imageable $imageable)
	{
		$data = [
			'project_id'    => $image->project->id,
			'type'          => Componentable::IMAGE,
			'visibility'    => true,
			'componentable' => [
				'image_id' => $image->id,
			],
		];

		return array_merge($data,
			self::position($imageable, $image->project->type),
			self::dimensions($imageable)
		);
	}



	/**
	 * @param Imageable $imageable
	 * @param Type $type
	 * @return array
	 */
	protected static function position(Imageable $imageable, Type $type)
	{
		// Use given positions
		if ($imageable->position() !== null) {
			return [
				'position_x' => $imageable->position()->x,
				'position_y' => $imageable->position()->y,
			];
		}

		// Center to the middle of the project space
		return [
			'position_x' => ($type->width - $imageable->dimensions()->width) / 2,
			'position_y' => ($type->height - $imageable->dimensions()->height) / 2,
		];
	}



	/**
	 * @param Imageable $imageable
	 * @return array
	 */
	protected static function dimensions(Imageable $imageable)
	{
		return [
			'width'  => $imageable->dimensions()->width,
			'height' => $imageable->dimensions()->height,
		];
	}
}
