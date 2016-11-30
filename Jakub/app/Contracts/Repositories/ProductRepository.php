<?php

namespace App\Contracts\Repositories;

use App\Models\Feed\Product;
use Illuminate\Support\Collection;



interface ProductRepository
{

	/**
	 * @param Collection|array $products
	 * @return Product[]|Collection
	 */
	public function createFromCollection($products);
}
