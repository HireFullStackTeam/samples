<?php

namespace App\Feed\Mappers\Facebook;

trait FacebookItemTransformation
{

	/**
	 * {@inheritdoc}
	 */
	public function transform($item)
	{
		return [
			'external_id'  => (string) $item->id,
			'title'        => $item->title,
			'price'        => (float) $item->price,
			'link'         => $item->link,
			'image_link'   => $item->image_link,
			'condition'    => $item->condition,
			'availability' => $item->availability
		];
	}
}
