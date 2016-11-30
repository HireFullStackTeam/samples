<?php

namespace App\Contracts\Feed\Factory;

use App\Contracts\Feed\Parser;
use App\Contracts\Feed\File;



interface ParserFactory
{

	/**
	 * @param File $file
	 * @return Parser|null
	 */
	public function create(File $file);
}
