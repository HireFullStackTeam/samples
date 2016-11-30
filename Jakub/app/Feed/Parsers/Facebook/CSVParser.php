<?php

namespace App\Feed\Parsers\Facebook;

use App\Feed\Parsers\TextParser;



class CSVParser extends TextParser
{

	/**
	 * @var string
	 */
	protected $delimiter = ',';

}
