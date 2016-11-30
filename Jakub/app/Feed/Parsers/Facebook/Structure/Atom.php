<?php

namespace App\Feed\Parsers\Facebook\Structure;

use Sabre\Xml\Reader;
use Sabre\Xml\XmlDeserializable;



class Atom implements XmlDeserializable
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
	 * @var Item[]
	 */
	public $items = [];



	/**
	 * {@inheritdoc}
	 */
	public static function xmlDeserialize(Reader $reader)
	{
		$feed = new self;

		$tree = Support::cleanNamespace($reader->parseInnerTree(), 'name', 'http://www.w3.org/2005/Atom');

		foreach ($tree as $leaf) {
			self::addToAtom($feed, $leaf);
		}

		return $feed;
	}



	/**
	 * @param Atom  $feed
	 * @param array $leaf
	 * @return mixed
	 */
	public static function addToAtom(Atom $feed, array $leaf)
	{
		if ($leaf['value'] instanceof Item) {
			return $feed->items[] = $leaf['value'];
		}

		if ($leaf['name'] === 'link' && $leaf['attributes']['rel'] === 'self') {
			return $feed->link = $leaf['attributes']['href'];
		}

		if ($feed->variableExists($property = $leaf['name']) === true) {
			return $feed->$property = $leaf['value'];
		}

		return null;
	}
}
