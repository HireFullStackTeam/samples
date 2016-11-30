<?php

namespace App\Feed\Parsers;

use App\Contracts\Feed\File;
use App\Contracts\Feed\Mapper;
use App\Models\Feed\Product;
use Exception;
use Illuminate\Support\Collection;
use LogicException;



trait MapsToProducts
{

	/**
	 * @var Mapper
	 */
	protected $mapper;



	/**
	 * @param Mapper $mapper
	 */
	public function registerMapper(Mapper $mapper)
	{
		$this->mapper = $mapper;
	}



	/**
	 * @param File $file
	 * @return Product[]|Collection
	 */
	public function mapToProductsFrom(File $file)
	{
		$this->validateHasMapper();

		if (empty($this->items) === true) {
			$this->parse($file->path());
		}

		return $this->mapper->map($this->items);
	}



	/**
	 * @return Product[]|Collection
	 */
	public function mapToProducts()
	{
		$this->validateHasMapper()
			->validateItemsAreAlreadyParsed();

		return $this->mapper->map($this->items);
	}



	/**
	 * @return $this
	 * @throws LogicException
	 */
	protected function validateHasMapper()
	{
		if (is_null($this->mapper)) {
			throw new LogicException('You have to register a mapper.'); // TODO make custom exception
		}

		return $this;
	}



	/**
	 * @return $this
	 * @throws Exception
	 */
	protected function validateItemsAreAlreadyParsed()
	{
		if (empty($this->items) === true) {
			throw new Exception('You have to parse a file first.'); // TODO make custom exception
		}

		return $this;
	}
}
