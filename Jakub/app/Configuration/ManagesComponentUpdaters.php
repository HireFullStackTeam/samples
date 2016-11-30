<?php

namespace App\Configuration;

use App\Contracts\Feesy\Components\Partials\Update;
use Illuminate\Support\Arr;



trait ManagesComponentUpdaters
{

	/**
	 * @var Update[]
	 */
	public static $updaters;



	/**
	 * @return Update[]
	 */
	public static function componentUpdaters()
	{
		return self::$updaters;
	}



	/**
	 * @param array $updaters
	 */
	public static function updateComponentWith(array $updaters)
	{
		self::$updaters = $updaters;
	}



	/**
	 * @param string $attribute
	 * @return bool
	 */
	public static function existsComponentUpdaterFor($attribute)
	{
		return array_key_exists($attribute, self::$updaters) === true;
	}



	/**
	 * @param string $key
	 * @return string
	 */
	public static function componentUpdaterNameBy($key)
	{
		$updaters = Arr::dot(self::$updaters);

		if (array_key_exists($key, $updaters) === true) {
			return $updaters[$key];
		}

		return null;
	}
}
