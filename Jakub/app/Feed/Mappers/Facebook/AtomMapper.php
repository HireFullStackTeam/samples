<?php

namespace App\Feed\Mappers\Facebook;

use App\Feed\Mappers\AbstractMapper;



class AtomMapper extends AbstractMapper
{

	use FacebookItemTransformation;



	/**
	 * {@inheritdoc}
	 */
	public function map($atom)
	{
		return parent::map($atom->items);
	}
}
