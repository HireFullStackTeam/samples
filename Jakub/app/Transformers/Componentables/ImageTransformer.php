<?php

namespace App\Transformers\Componentables;

use App\Models\Componentables\Image;
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
			'path' => (string) $image->path,
		];
	}
}
