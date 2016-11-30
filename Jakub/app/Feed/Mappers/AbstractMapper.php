<?php

namespace App\Feed\Mappers;

use App\Contracts\Feed\Mapper as Contract;
use App\Models\Feed\Product;
use Illuminate\Support\Collection;



abstract class AbstractMapper implements Contract
{

	/**
	 * {@inheritdoc}
	 */
	public function map($items)
	{
		if (is_array($items)) {
			$items = $items instanceof Collection ?: collect($items);

			return $this->hydrate($items->map(function ($item) {
				return $this->transform($item);
			}));
		}

		return new Product($this->transform($items));
	}



	/**
	 * @param Collection $items
	 * @return \Illuminate\Database\Eloquent\Collection|Product[]
	 */
	protected function hydrate(Collection $items)
	{
		return Product::hydrate($items->toArray());
	}
}
