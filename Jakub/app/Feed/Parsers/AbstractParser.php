<?php

namespace App\Feed\Parsers;

use App\Contracts\Feed\Parser;
use Illuminate\Support\Collection;



abstract class AbstractParser implements Parser
{

	use MapsToProducts;

	/**
	 * @var array|Collection
	 */
	protected $items = [];



	/**
	 * {@inheritdoc}
	 */
	public function items()
	{
		return $this->items;
	}
}
