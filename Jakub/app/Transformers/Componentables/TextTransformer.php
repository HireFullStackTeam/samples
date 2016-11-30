<?php

namespace App\Transformers\Componentables;


use App\Models\Componentables\Text;
use League\Fractal\TransformerAbstract;



class TextTransformer extends TransformerAbstract
{

	/**
	 * @param Text $text
	 * @return array
	 */
	public function transform(Text $text)
	{
		return [
			'content' => $text->content,
			'state'   => $text->state
		];
	}
}
