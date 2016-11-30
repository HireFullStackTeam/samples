<?php

namespace App\Feed\Validator\Validation\Text;

use App\Contracts\Feed\Validation;
use App\Feed\Validator\TextFileSchema;



class RequiredFields implements Validation
{

	/**
	 * @param array $header
	 * @return bool
	 */
	public function validate(array $header)
	{
		foreach (TextFileSchema::required() as $name => $definition) {
			if ($this->fieldExists($name, $header) === false || $this->isOccurrenceOnce($name, $header) === false) {
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
	protected function fieldExists($name, array $header)
	{
		return in_array($name, $header) === true;
	}



	/**
	 * @param array $header
	 * @param string $name
	 * @return bool
	 */
	protected function isOccurrenceOnce($name, array $header)
	{
		return array_count_values($header)[$name] == 1;
	}

}
