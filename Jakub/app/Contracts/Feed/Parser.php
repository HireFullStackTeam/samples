<?php

namespace App\Contracts\Feed;

use App\Models\Feed\Product;
use Exception;
use Illuminate\Support\Collection;



interface Parser
{

	/**
	 * @param string $path
	 * @return $this
	 */
	public function parse($path);



	/**
	 * @return array|Collection
	 */
	public function items();



	/**
	 * @param string $path
	 * @return bool
	 */
	public function match($path);



	/**
	 * @param File $file
	 * @return Product[]|Collection
	 */
	public function mapToProductsFrom(File $file);



	/**
	 * @return Product[]|Collection
	 * @throws Exception
	 */
	public function mapToProducts();



	/**
	 * @param Mapper $mapper
	 */
	public function registerMapper(Mapper $mapper);
}
