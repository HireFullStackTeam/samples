<?php

namespace App\Feed\Mappers\Facebook;

use App\Feed\Mappers\AbstractMapper;



class RSSMapper extends AbstractMapper
{

	use FacebookItemTransformation;



	/**
	 * {@inheritdoc}
	 */
	public function map($rss)
	{
		return parent::map($rss->channel->items);
	}
}
