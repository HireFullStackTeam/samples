<?php

namespace App\Contracts\Feed\Factory;

use League\Csv\Reader;



interface ReaderFactory
{

	/**
	 * @param string $path
	 * @param string $delimiter
	 * @return Reader
	 */
	public function createFromPath($path, $delimiter);
}
