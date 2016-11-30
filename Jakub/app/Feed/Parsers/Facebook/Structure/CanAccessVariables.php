<?php

namespace App\Feed\Parsers\Facebook\Structure;

trait CanAccessVariables
{

	/**
	 * @return array
	 */
	public function variables()
	{
		return get_object_vars($this);
	}



	/**
	 * @param string $variable
	 * @return bool
	 */
	public function variableExists($variable)
	{
		return array_key_exists($variable, $this->variables()) === true;
	}

}
