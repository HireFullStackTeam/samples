<?php

namespace App\Feed\Parsers\Facebook;

use App\Contracts\Feed\Parser;
use App\Feed\Parsers\Facebook\Structure\Channel;
use App\Feed\Parsers\Facebook\Structure\Item;
use App\Feed\Parsers\Facebook\Structure\Rss;
use App\Feed\Parsers\Facebook\Structure\Shipping;
use App\Feed\Parsers\XmlParser;



class RSSParser extends XmlParser implements Parser
{

	/**
	 * @var string
	 */
	protected $namespace = 'http://base.google.com/ns/1.0';

	/**
	 * @var string
	 */
	protected $schema = 'app/feed/schema/rss.xsd';

	/**
	 * @var string
	 */
	protected $rootNodeName = 'rss';



	/**
	 * {@inheritdoc}
	 */
	public function parse($path)
	{
		$this->sabreXmlService->elementMap = [
			'rss'                                => Rss::class,
			'channel'                            => Channel::class,
			'item'                               => Item::class,
			'{' . $this->namespace . '}shipping' => Shipping::class,
		];

		$this->items = $this->sabreXmlService->parse(
			$this->files->get($path)
		);

		return $this;
	}
}
