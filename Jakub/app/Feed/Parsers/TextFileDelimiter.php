<?php

namespace App\Feed\Parsers;

use Illuminate\Support\Arr;
use SplFileObject;



class TextFileDelimiter
{

	/**
	 * @var array
	 */
	protected $results = [];

	/**
	 * @var int
	 */
	protected $linesToCheck = 3;

	/**
	 * @var SplFileObject
	 */
	protected $file;

	/**
	 * @var string[]
	 */
	protected $supportedDelimiters = [
		",",
		"\t"
	];



	/**
	 * @param SplFileObject $file
	 */
	protected function __construct(SplFileObject $file)
	{
		$this->file = $file;
	}



	/**
	 * @param int $lines
	 * @return $this
	 */
	public function checkLines($lines = 3)
	{
		$this->linesToCheck = $lines;

		return $this;
	}



	/**
	 * @return string|bool
	 */
	public function mostUsedDelimiter()
	{
		$this->calculateDelimitersUsage();

		// Prevent error max() if $this->results are empty
		if (empty($this->results) === true) {
			return false;
		}

		return Arr::first(
			array_keys($this->results, max($this->results))
		);
	}



	/**
	 * @param string $delimiter
	 * @return bool
	 */
	public function against($delimiter)
	{
		return $this->mostUsedDelimiter() === $delimiter;
	}



	/**
	 * @param string $filePath
	 * @param int    $checkLines
	 * @return string|false
	 */
	public static function resolve($filePath, $checkLines = 3)
	{
		$delimiter = (new self(new SplFileObject($filePath)))
			->checkLines($checkLines);

		return $delimiter->mostUsedDelimiter();
	}



	/**
	 * @param string $filePath
	 * @return TextFileDelimiter
	 */
	public static function check($filePath)
	{
		return (new self(
			new SplFileObject($filePath)
		));
	}



	/**
	 * @param string $delimiter
	 * @param array  $line
	 * @return bool
	 */
	protected function matchesLine($delimiter, $line)
	{
		return count(preg_split('/[' . $delimiter . ']/', $line)) > 1;
	}



	/**
	 * @param string $delimiter
	 */
	protected function increase($delimiter)
	{
		$this->results[$delimiter] = isset($this->results[$delimiter])
			? $this->results[$delimiter] + 1
			: 1;
	}



	protected function calculateDelimitersUsage()
	{
		for ($i = 0; $i < $this->linesToCheck; $i++) {
			if ($this->file->valid() === false) {
				break;
			}

			$line = $this->file->fgets();

			foreach ($this->supportedDelimiters as $delimiter) {
				if ($this->matchesLine($delimiter, $line)) {
					$this->increase($delimiter);
				}
			}
		}
	}
}
