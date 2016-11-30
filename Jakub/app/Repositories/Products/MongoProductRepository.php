<?php

namespace App\Repositories\Products;

use App\Contracts\Repositories\ProductRepository;
use App\Models\Feed\Product;



class MongoProductRepository implements ProductRepository
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
		//
	}
}
