<?php

namespace App\Feed\Validator\Validation\Text;

use App\Contracts\Feed\Validation;
use App\Feed\Validator\TextFileSchema;



class OneOfs implements Validation
{

	/**
	 * @param array $header
	 * @return bool
	 */
	public function validate(array $header)
	{
		$found = false;

		foreach (TextFileSchema::oneOfs() as $oneOf) {
			foreach ($oneOf as $name => $definition) {
				if ($this->fieldExists($name, $header) === true) {
					$found = true;
				}
			}
		}

		return $found;
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

}
