<?php

namespace App\Feed\Parsers\Facebook;

use App\Contracts\Feed\Parser;
use App\Feed\Parsers\Facebook\Structure\Atom;
use App\Feed\Parsers\Facebook\Structure\Item;
use App\Feed\Parsers\Facebook\Structure\Shipping;
use App\Feed\Parsers\XmlParser;



class AtomParser extends XmlParser implements Parser
{

	/**
	 * @var string
	 */
	protected $atom = 'http://www.w3.org/2005/Atom';

	/**
	 * @var string
	 */
	protected $g = 'http://base.google.com/ns/1.0';

	/**
	 * @var string
	 */
	protected $schema = 'app/feed/schema/atom.xsd';

	/**
	 * @var string
	 */
	protected $rootNodeName = 'feed';



	/**
	 * {@inheritdoc}
	 */
	public function parse($path)
	{
		$this->sabreXmlService->elementMap = [
			'{' . $this->atom . '}feed'  => Atom::class,
			'{' . $this->atom . '}entry' => Item::class,
			'{' . $this->g . '}shipping' => Shipping::class,
		];

		$this->items = $this->sabreXmlService->parse(
			$this->files->get($path)
		);

		return $this;
	}
}
