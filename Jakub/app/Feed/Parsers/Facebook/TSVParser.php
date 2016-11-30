<?php

namespace App\Feed\Parsers\Facebook;

use App\Feed\Parsers\TextParser;



class TSVParser extends TextParser
{

	/**
	 * @var string
	 */
	protected $delimiter = "\t";

}
