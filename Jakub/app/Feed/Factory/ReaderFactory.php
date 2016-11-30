<?php

namespace App\Feed\Factory;

use App\Contracts\Feed\Factory\ReaderFactory as Contract;
use League\Csv\Reader;



class ReaderFactory implements Contract
{

	/**
	 * @param string $path
	 * @param string $delimiter
	 * @return Reader
	 */
	public function createFromPath($path, $delimiter)
	{
		$reader = Reader::createFromPath($path);
		$reader->setDelimiter($delimiter);

		return $reader;
	}
}
