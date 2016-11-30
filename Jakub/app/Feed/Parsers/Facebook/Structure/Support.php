<?php

namespace App\Feed\Parsers\Facebook\Structure;

use Illuminate\Support\Str;



abstract class Support
{

	/**
	 * @param array        $values
	 * @param string       $key
	 * @param string|array $namespaces
	 * @return array
	 */
	public static function cleanNamespace(array $values, $key, $namespaces = '')
	{
		foreach ($values as &$value) {
			foreach ((array) $namespaces as $namespace) {
				$value[$key] = Str::replaceFirst('{' . $namespace . '}', '', $value[$key]);
			}
		}

		return $values;
	}



	/**
	 * @param string $value
	 * @return string|null
	 */
	public static function normalize($value)
	{
		return ($value !== '') ? $value : null;
	}
}
