<?php

namespace App\Feed\Validator;

use App\Contracts\Feed\Factory\ReaderFactory;
use App\Contracts\Feed\Validation;
use App\Feed\Validator\Validation\Text\OneOfs;
use App\Feed\Validator\Validation\Text\OptionalFields;
use App\Feed\Validator\Validation\Text\RequiredFields;



class TextValidator
{

	/**
	 * @var array
	 */
	protected $data;

	/**
	 * @var ReaderFactory
	 */
	protected $reader;

	/**
	 * @var Validation[]
	 */
	protected $validations = [
		RequiredFields::class,
		OptionalFields::class,
		OneOfs::class
	];



	/**
	 * @param ReaderFactory $reader
	 */
	public function __construct(ReaderFactory $reader)
	{
		$this->reader = $reader;
	}



	/**
	 * @param string $path
	 * @param string $delimiter
	 * @return bool
	 */
	public function validate($path, $delimiter)
	{
		$header = $this->reader->createFromPath($path, $delimiter)->fetchOne();

		foreach ($this->validations as $validation) {
			if ((new $validation)->validate($header) === false) {
				return false;
			}
		}

		return true;
	}



	/**
	 * @return $this
	 */
	protected function validateLineFieldsCount()
	{
		$headerCount = count($this->header);

		foreach ($this->data as $key => $line) {

			$lineCount = count($line);
			$rightLineNumber = $key + 2;

			if ($headerCount !== $lineCount) {
				// throw new Exception('Different number of items ['.$lineCount.'] which differ from headers ['.$headerCount.'] on line ' . $rightLineNumber . '.');
				var_dump('Different number of items [' . $lineCount . '] which differ from headers [' . $headerCount . '] on line ' . $rightLineNumber . '.');
			}
		}

		return $this;
	}



	/**
	 * @return $this
	 */
	protected function validateLine()
	{
		$rules = TextFileSchema::rules()->toArray();

		$ruleableItems = array_merge(
			TextFileSchema::required()->toArray(),
			TextFileSchema::optional()->toArray(),
			$this->normalizeOneOfs(
				TextFileSchema::oneOfs()->toArray()
			)
		);

		// Only best coding style http://imgur.com/BtjZedW

		foreach ($this->data as $line) {

			$data = array_combine($this->header, $line);

			foreach ($data as $id => $value) {

				if (array_key_exists($id, $ruleableItems)) {

					$allRules = explode('|', $ruleableItems[$id]['rule']);

					$passes = false;

					foreach ($allRules as $rule) {
						$regex = $rules[$rule];

						if ($passes === true) {
							continue;
						}

						if (preg_match($regex, $value) === 1) {
							$passes = true;
						}
					}

					if ($passes === false) {
						var_dump('Wrong data ' . $id . ' format [' . $value . '] field');
					}
				}
			}
		}

		return $this;
	}



	/**
	 * @param array $oneOfs
	 * @return array
	 */
	protected function normalizeOneOfs($oneOfs)
	{
		$normalised = [];

		foreach ($oneOfs as $one) {
			$normalised += $one;
		}

		return $normalised;
	}

}
