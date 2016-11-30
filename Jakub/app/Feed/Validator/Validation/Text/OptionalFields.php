<?php

namespace App\Feed\Validator\Validation\Text;

use App\Contracts\Feed\Validation;
use App\Feed\Validator\TextFileSchema;



class OptionalFields implements Validation
{

	/**
	 * @var int
	 */
	protected $maxOccurrence = 1;



	/**
	 * @param array $header
	 * @return bool
	 */
	public function validate(array $header)
	{
		foreach (TextFileSchema::optional() as $name => $definition) {
			if ($this->isCorrectMaxOccurrence($name, $header) === false) {
				// var_dump('Found more ' . $name . 's than allowed.'); // TODO

				return false;
			}
		}

		return true;
	}



	/**
	 * @param string $name
	 * @param array $header
	 * @return bool
	 */
	protected function isCorrectMaxOccurrence($name, array $header)
	{
		if (in_array($name, $header) === true) {
			return array_count_values($header)[$name] <= $this->maxOccurrence;
		}

		return true;
	}
}
