<?php

namespace App\Repositories\Products;

use App\Contracts\Repositories\ProductRepository;
use App\Models\Feed\Product;
use Carbon\Carbon;
use Illuminate\Support\Collection;



class DatabaseProductRepository implements ProductRepository
{

	/**
	 * @var Product
	 */
	protected $products;



	/**
	 * @param Product $products
	 */
	public function __construct(Product $products)
	{
		$this->products = $products;
	}



	/**
	 * {@inheritdoc}
	 */
	public function createFromCollection($products)
	{
		// TODO add project_id

		$products = $products instanceof Collection
			? $products->map(function ($product) {
				return $product;
			})->toArray()
			: $products;

		$dates = [
			'created_at' => Carbon::now(),
			'updated_at' => Carbon::now(),
		];

		$inserted = $this->products->insert(array_map(function ($product) use ($dates) {
			return array_merge($product, $dates);
		}, $products));


		// TODO returns product collection for feed test

		if ($inserted === true) {
			return collect($products);
		}

		return false;
	}
}
