<?php

namespace App\Transformers\Componentables;

use App\Models\Componentables\Shape;
use League\Fractal\TransformerAbstract;



class ShapeTransformer extends TransformerAbstract
{

	/**
	 * @param \App\Models\Componentables\Shape $shape
	 * @return array
	 */
	public function transform(Shape $shape)
	{
		return [
			'shape_id' => $shape->shape_id,
			'color'    => $shape->color,
			'content'  => $shape->content
		];
	}
}
