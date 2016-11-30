<?php

namespace App\Repositories\Products;

use App\Contracts\Repositories\ProductBenchmarkRepository as TimeContract;
use App\Contracts\Repositories\ProductRepository;
use PHP_Timer;



class ProductBenchmarkRepository implements ProductRepository, TimeContract
{

	/**
	 * @var ProductRepository
	 */
	protected $repository;

	/**
	 * @var float
	 */
	protected $time;



	/**
	 * @param ProductRepository $repository
	 */
	public function __construct(ProductRepository $repository)
	{
		$this->repository = $repository;
	}



	/**
	 * {@inheritdoc}
	 */
	public function createFromCollection($products)
	{
		PHP_Timer::start();

		$this->repository->createFromCollection($products);

		$this->time = PHP_Timer::stop();
	}



	/**
	 * @return float
	 */
	public function time()
	{
		return $this->time;
	}
}
