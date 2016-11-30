<?php

namespace App\Contracts\Repositories;

interface ProductBenchmarkRepository extends ProductRepository
{

	/**
	 * @return float
	 */
	public function time();
}
