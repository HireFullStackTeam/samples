<?php

namespace Tests\Integration\Validator\Validation\Text;

use App\Feed\Validator\Validation\Text\OptionalFields;
use Tests\TestCase;



class OptionalFieldsTest extends TestCase
{

	/**
	 * @var string[]
	 */
	protected $validAll = [
		'ios_url',
		'ios_app_store_id',
		'ios_app_name',
		'iphone_url',
		'iphone_app_store_id',
		'iphone_app_name',
		'ipad_url',
		'ipad_app_store_id',
		'ipad_app_name',
		'android_url',
		'android_package',
		'android_app_name',
		'windows_phone_url',
		'windows_phone_app_id',
		'windows_phone_app_name',
		'additional_image_link',
		'age_group',
		'color',
		'expiration_date',
		'gender',
		'item_group_id',
		'google_product_category',
		'material',
		'pattern',
		'product_type',
		'sale_price',
		'sale_price_effective_date',
		'shipping',
		'shipping_weight',
		'shipping_size',
		'custom_label_0',
		'custom_label_1',
		'custom_label_2',
		'custom_label_3',
		'custom_label_4'
	];

	/**
	 * @var string[]
	 */
	protected $validOne = [
		'ios_url'
	];

	/**
	 * @var array
	 */
	protected $validEmpty = [];

	/**
	 * @var string[]
	 */
	protected $invalid = [
		'additional_image_link',
		'additional_image_link'
	];



	/** @test */
	public function it_validates_valid_all_optionals()
	{
		$this->assertTrue((new OptionalFields)->validate($this->validAll));
	}



	/** @test */
	public function it_validates_valid_one_optional()
	{
		$this->assertTrue((new OptionalFields)->validate($this->validOne));
	}



	/** @test */
	public function it_validates_valid_empty_optional()
	{
		$this->assertTrue((new OptionalFields)->validate($this->validEmpty));
	}



	/** @test */
	public function it_validates_invalid_optionals()
	{
		$this->assertFalse((new OptionalFields)->validate($this->invalid));
	}
}