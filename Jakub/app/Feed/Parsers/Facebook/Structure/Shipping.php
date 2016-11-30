<?php

namespace App\Feed\Parsers\Facebook\Structure;

use Sabre\Xml\Reader;
use Sabre\Xml\XmlDeserializable;



class Shipping implements XmlDeserializable
{

	use CanAccessVariables;

	/**
	 * @var string
	 */
	public $country;

	/**
	 * @var string
	 */
	public $region;

	/**
	 * @var string
	 */
	public $postal_code;

	/**
	 * @var string
	 */
	public $location_id;

	/**
	 * @var string
	 */
	public $location_group_name;

	/**
	 * @var string
	 */
	public $service;

	/**
	 * @var string
	 */
	public $price;

	/**
	 * @var string[]
	 */
	public static $properties = [
		'country',
		'region',
		'service',
		'price',
	];



	/**
	 * {@inheritdoc}
	 */
	public static function xmlDeserialize(Reader $reader)
	{
		$shipping = new self;

		$values = \Sabre\Xml\Deserializer\keyValue($reader, 'http://base.google.com/ns/1.0');

		foreach ($values as $key => $value) {
			$shipping->$key = $value;
		}

		return $shipping;
	}



	/**
	 * @param array $values
	 * @return Shipping
	 */
	public static function create(array $values)
	{
		$shipping = new self;

		array_walk($values, function ($value, $property) use ($shipping) {
			$shipping->{$property} = Support::normalize($value);
		});

		return $shipping;
	}



	/**
	 * @param string $string
	 * @return array
	 */
	public static function createFromString($string)
	{
		return array_map(function ($shipping) {
			$values = array_combine(
				self::$properties, explode(':', $shipping)
			);

			return self::create($values);
		}, explode(',', $string));
	}
}
