<?php

namespace App\Feed\Parsers\Facebook\Structure;

use Sabre\Xml\Reader;
use Sabre\Xml\XmlDeserializable;



class Channel implements XmlDeserializable
{

	use CanAccessVariables;

	/**
	 * @var string
	 */
	public $title;

	/**
	 * @var string
	 */
	public $link;

	/**
	 * @var string
	 */
	public $description;

	/**
	 * @var Item
	 */
	public $items = [];



	/**
	 * {@inheritdoc}
	 */
	public static function xmlDeserialize(Reader $reader)
	{
		$channel = new self;

		$tree = Support::cleanNamespace($reader->parseInnerTree(), 'name');

		foreach ($tree as $leaf) {
			self::addToChannel($channel, $leaf);
		}

		return $channel;
	}



	/**
	 * @param Channel $channel
	 * @param array   $leaf
	 * @return Item|string
	 */
	public static function addToChannel(Channel $channel, array $leaf)
	{
		if ($leaf['value'] instanceof Item) {
			return $channel->items[] = $leaf['value'];
		}

		return $channel->{$leaf['name']} = $leaf['value'];
	}
}
