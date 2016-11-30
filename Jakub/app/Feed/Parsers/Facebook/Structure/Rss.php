<?php

namespace App\Feed\Parsers\Facebook\Structure;

use Sabre\Xml\Reader;
use Sabre\Xml\XmlDeserializable;



class Rss implements XmlDeserializable
{

	/**
	 * @var Channel
	 */
	public $channel;



	/**
	 * {@inheritdoc}
	 */
	public static function xmlDeserialize(Reader $reader)
	{
		$rss = new self;

		$values = \Sabre\Xml\Deserializer\keyValue($reader, '');

		foreach ($values as $key => $value) {
			$rss->$key = $value;
		}

		return $rss;
	}
}
