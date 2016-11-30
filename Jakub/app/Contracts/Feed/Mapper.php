<?php

namespace App\Contracts\Feed;

use App\Models\Feed\Product;



interface Mapper
{

	/**
	 * @param object $item
	 * @return array
	 */
	public function transform($item);



	/**
	 * @param object|array $data
	 * @return Product[]
	 */
	public function map($data);
}
