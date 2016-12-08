<?php

namespace App\Feed;

use App\Contracts\Feed\Factory\FileFactory;
use App\Contracts\Feed\Factory\ParserFactory;
use App\Contracts\Feed\Feed as Contract;
use App\Contracts\Repositories\ProductRepository;
use App\Repositories\Products\ProductBenchmarkRepository;



class Feed implements Contract
{

	/**
	 * @var ParserFactory
	 */
	protected $parserFactory;

	/**
	 * @var ProductRepository
	 */
	protected $products;

	/**
	 * @var FileFactory
	 */
	protected $fileFactory;



	/**
	 * @param ParserFactory     $parserFactory
	 * @param ProductRepository $products
	 * @param FileFactory       $fileFactory
	 */
	public function __construct(
		ParserFactory $parserFactory,
		ProductRepository $products,
		FileFactory $fileFactory
	) {
		$this->parserFactory = $parserFactory;
		$this->products = $products;
		$this->fileFactory = $fileFactory;
	}



	/**
	 * {@inheritdoc}
	 */
	public function handle($file)
	{
		$file = $this->fileFactory->create($file);

		$repository = new ProductBenchmarkRepository($this->products);

		if ($parser = $this->parserFactory->create($file)) {
			return $repository->createFromCollection(
				$parser->mapToProductsFrom($file)
			);
		}

		return false;
	}
}
