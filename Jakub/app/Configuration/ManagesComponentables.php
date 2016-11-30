<?php

namespace App\Configuration;

use App\Models\Componentables\Componentable;
use App\Models\Componentables\Image;
use App\Models\Componentables\Shape;
use App\Models\Componentables\Text;
use App\Support\Dimensions;
use InvalidArgumentException;



trait ManagesComponentables
{

	/**
	 * @var string[]
	 */
	protected static $morphMap = [
		Componentable::TEXT  => Text::class,
		Componentable::SHAPE => Shape::class,
		Componentable::IMAGE => Image::class,
	];

	/**
	 * @var array
	 */
	protected static $dimensions = [];



	/**
	 * @return string[]
	 */
	public static function componentablesMorphMap()
	{
		return self::$morphMap;
	}



	/**
	 * App\Models\Componentables\Text (class) => text (type)
	 *
	 * @param string $class
	 * @return string
	 */
	public static function componentableTypeOf($class)
	{
		if (in_array($class, self::$morphMap) === false) {
			throw new InvalidArgumentException('The class [' . $class . '] does not have defined any type.');
		}

		return array_search($class, self::$morphMap);
	}



	/**
	 * text (type) => App\Models\Componentables\Text (class)
	 *
	 * @param string $type
	 * @return string
	 */
	public static function componentableClassBy($type)
	{
		if (isset(self::$morphMap[$type]) === false) {
			throw new InvalidArgumentException('The componentable type [' . $type . '] does not exist.');
		}

		return self::$morphMap[$type];
	}



	/**
	 * @param string $class
	 * @throws InvalidArgumentException
	 * @return Dimensions
	 */
	public static function dimensionsFor($class)
	{
		if (isset(self::$dimensions[$class]) === true) {
			return Dimensions::fromArray(self::$dimensions[$class]);
		}

		if (in_array($class, self::$morphMap) === true) {
			return Dimensions::fromArray(
				self::$dimensions[self::componentableTypeOf($class)]
			);
		}

		throw new InvalidArgumentException('Cannot find dimensions for ' . $class . '.');
	}



	/**
	 * @param array $dimensions
	 */
	public static function useDimensions(array $dimensions)
	{
		self::$dimensions = $dimensions;
	}
}
