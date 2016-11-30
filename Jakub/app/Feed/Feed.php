<?php

namespace App\Feed;

use App\Contracts\Feed\Factory\ParserFactory;
use App\Contracts\Feed\Feed as Contract;
use App\Contracts\Repositories\ProductRepository;



class Feed implements Contract
{

	/**
	 * @var ParserFactory
	 */
	protected $factory;

	/**
	 * @var ProductRepository
	 */
	protected $products;



	/**
	 * @param ParserFactory     $factory
	 * @param ProductRepository $products
	 */
	public function __construct(
		ParserFactory $factory,
		ProductRepository $products
	) {
		$this->factory = $factory;
		$this->products = $products;
	}



	/**
	 * {@inheritdoc}
	 */
	public function handle($file)
	{
		$file = new File($file);

		if ($parser = $this->factory->create($file)) {
			return $this->products->createFromCollection(
				$parser->mapToProductsFrom($file)
			);
		}

		return false; // TODO temporary return false for tests
		// todo throw an exceptions - unresolved file format
	}
}
