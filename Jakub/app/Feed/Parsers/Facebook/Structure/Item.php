<?php

namespace App\Feed\Parsers\Facebook\Structure;

use Sabre\Xml\Reader;
use Sabre\Xml\XmlDeserializable;



class Item implements XmlDeserializable
{

	use CanAccessVariables;

	/**
	 * @var int
	 */
	public $id;

	/**
	 * @var string
	 */
	public $title;

	/**
	 * @var string
	 */
	public $description;

	/**
	 * @var string
	 */
	public $link;

	/**
	 * @var string
	 */
	public $image_link;

	/**
	 * @var string
	 */
	public $condition;

	/**
	 * @var string
	 */
	public $availability;

	/**
	 * @var string
	 */
	public $price;

	/**
	 * @var string
	 */
	public $google_product_category;

	/**
	 * @var string
	 */
	public $gtin;

	/**
	 * @var string
	 */
	public $mpn;

	/**
	 * @var string
	 */
	public $brand;

	/**
	 * @var string
	 */
	public $product_type;

	/**
	 * @var string
	 */
	public $ios_url;

	/**
	 * @var string
	 */
	public $ios_app_store_id;

	/**
	 * @var string
	 */
	public $ios_app_name;

	/**
	 * @var string
	 */
	public $iphone_url;

	/**
	 * @var string
	 */
	public $iphone_app_store_id;

	/**
	 * @var string
	 */
	public $iphone_app_name;

	/**
	 * @var string
	 */
	public $ipad_url;

	/**
	 * @var string
	 */
	public $ipad_app_store_id;

	/**
	 * @var string
	 */
	public $ipad_app_name;

	/**
	 * @var string
	 */
	public $android_url;

	/**
	 * @var string
	 */
	public $android_package;

	/**
	 * @var string
	 */
	public $android_app_name;

	/**
	 * @var string
	 */
	public $windows_phone_url;

	/**
	 * @var string
	 */
	public $windows_phone_app_id;

	/**
	 * @var string
	 */
	public $windows_phone_app_name;

	/**
	 * @var array
	 */
	public $additional_image_links = [];

	/**
	 * @var string
	 */
	public $age_group;

	/**
	 * @var string
	 */
	public $color;

	/**
	 * @var string
	 */
	public $expiration_date;

	/**
	 * @var string
	 */
	public $gender;

	/**
	 * @var string
	 */
	public $item_group_id;

	/**
	 * @var string
	 */
	public $material;

	/**
	 * @var string
	 */
	public $pattern;

	/**
	 * @var string
	 */
	public $sale_price;

	/**
	 * @var string
	 */
	public $sale_price_effective_date;

	/**
	 * @var Shipping[]
	 */
	public $shippings = [];

	/**
	 * @var string
	 */
	public $shipping_weight;

	/**
	 * @var string
	 */
	public $shipping_size;

	/**
	 * @var string
	 */
	public $custom_label_0;

	/**
	 * @var string
	 */
	public $custom_label_1;

	/**
	 * @var string
	 */
	public $custom_label_2;

	/**
	 * @var string
	 */
	public $custom_label_3;

	/**
	 * @var string
	 */
	public $custom_label_4;



	/**
	 * {@inheritdoc}
	 */
	public static function xmlDeserialize(Reader $reader)
	{
		$item = new static;

		$tree = Support::cleanNamespace(
			$reader->parseInnerTree(), 'name', ['http://base.google.com/ns/1.0', '']
		);

		foreach ($tree as $leaf) {
			self::add($item, $leaf);
		}

		return $item;
	}



	/**
	 * @param array  $values
	 * @param string $shippingKey
	 * @return Item
	 */
	public static function create(array $values, $shippingKey = 'shipping')
	{
		$item = new static;

		foreach ($item->variables() as $key => $value) {
			if (array_key_exists($key, $values) === true) {
				$item->$key = $values[$key];
			}
		}

		if (array_key_exists($shippingKey, $values) === true) {
			$item->shippings = Shipping::createFromString($values[$shippingKey]);
		}

		return $item;
	}



	/**
	 * @param Item  $item
	 * @param array $leaf
	 * @return mixed
	 */
	protected static function add(Item $item, array $leaf)
	{
		if ($leaf['value'] instanceof Shipping) {
			return array_push($item->shippings, $leaf['value']);
		}

		if ($leaf['name'] === 'applink') {
			$property = $leaf['attributes']['property'];

			if ($item->variableExists($property) === true) {
				return $item->$property = $leaf['attributes']['content'];
			}
		}

		if ($leaf['name'] === 'additional_image_link') {
			return array_push($item->additional_image_links, $leaf['value']);
		}

		if ($item->variableExists($property = $leaf['name']) === true) {
			return $item->$property = $leaf['value'];
		}

		return null;
	}
}
