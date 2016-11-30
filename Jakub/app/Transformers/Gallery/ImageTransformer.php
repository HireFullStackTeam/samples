<?php

namespace App\Transformers\Gallery;

use App\Models\Gallery\Image;
use League\Fractal\TransformerAbstract;



class ImageTransformer extends TransformerAbstract
{

	/**
	 * @param Image $image
	 * @return array
	 */
	public function transform(Image $image)
	{
		return [
			'id'   => (int) $image->id,
			'path' => (string) $image->path,
		];
	}
}
