<?php

namespace App\Gallery\Support;

use App\App;
use Intervention\Image\Constraint;
use Intervention\Image\Image;



class Dimensions extends \App\Support\Dimensions
{

	/**
	 * @param string $path
	 * @param int    $width
	 * @param int    $height
	 * @return Image
	 */
	public static function resize($path, $width = 2000, $height = 2000)
	{
		/** @var Image $image */
		$image = \Intervention\Image\Facades\Image::make(
			App::fileSystemStoragePath() . $path
		);

		if ($image->width() > $width || $image->height() > $height) {

			$image->resize($width, $height, function (Constraint $constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
			});

			$image->save(App::fileSystemStoragePath() . $path);
		}

		return $image;
	}

}
