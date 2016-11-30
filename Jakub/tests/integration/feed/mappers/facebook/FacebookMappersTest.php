<?php

namespace Tests\Integration\Feed\Mappers\Facebook;

use App\Feed\Mappers\Facebook\AtomMapper;
use App\Feed\Mappers\Facebook\RSSMapper;
use App\Feed\Mappers\Facebook\TextMapper;
use App\Feed\Parsers\Facebook\Structure\Atom;
use App\Feed\Parsers\Facebook\Structure\Channel;
use App\Feed\Parsers\Facebook\Structure\Item;
use App\Feed\Parsers\Facebook\Structure\Rss;
use App\Feed\Parsers\Facebook\Structure\Shipping;
use Tests\TestCase;



class FacebookMappersTest extends TestCase
{

	/**
	 * @var string[]
	 */
	protected $expected = [
		[
			'external_id'  => 'DB_2',
			'title'        => 'Dog Bowl In Blue',
			'price'        => 9.99,
			'link'         => 'http://www.example.com/bowls/db-1.html',
			'image_link'   => 'http://images.example.com/DB_1.png',
			'condition'    => 'new',
			'availability' => 'in stock'
		]
	];



	/** @test */
	public function it_maps_atom()
	{
		$this->assertSame(
			$this->expected, (new AtomMapper)->map($this->atom())->toArray()
		);
	}



	/** @test */
	public function it_maps_text()
	{
		$this->assertSame(
			$this->expected, (new TextMapper)->map([$this->item()])->toArray()
		);
	}



	/** @test */
	public function it_maps_rss()
	{
		$this->assertSame(
			$this->expected, (new RSSMapper)->map($this->rss())->toArray()
		);
	}



	/**
	 * @return Rss
	 */
	protected function rss()
	{
		$rss = new Rss;

		$rss->channel = $this->channel();

		return $rss;
	}



	/**
	 * @return Channel
	 */
	protected function channel()
	{
		$channel = new Channel;

		$channel->items = [
			$this->item()
		];

		return $channel;
	}



	/**
	 * @return Atom
	 */
	protected function atom()
	{
		$atom = new Atom;

		$atom->items = [
			$this->item()
		];

		return $atom;
	}



	/**
	 * @return Item
	 */
	protected function item()
	{
		$item = new Item;

		$item->id = 'DB_2';
		$item->title = 'Dog Bowl In Blue';
		$item->description = 'Solid plastic Dog Bowl in marine blue color';
		$item->link = 'http://www.example.com/bowls/db-1.html';
		$item->image_link = 'http://images.example.com/DB_1.png';
		$item->condition = 'new';
		$item->availability = 'in stock';
		$item->price = '9.99 GBP';
		$item->google_product_category = 'Animals > Pet Supplies';
		$item->gtin = '978-1-56619-909-1';
		$item->mpn = 'Example mpn';
		$item->brand = 'Example brand';
		$item->product_type = 'Bowls & Dining > Food & Water Bowls';
		$item->ios_url = 'example-ios://electronic/db_1';
		$item->ios_app_store_id = '123';
		$item->ios_app_name = 'Electronic Example iOS';
		$item->iphone_url = 'example-iphone://electronic';
		$item->iphone_app_store_id = '5678';
		$item->iphone_app_name = 'Electronic Example iPhone';
		$item->ipad_url = 'example-ipad://electronic';
		$item->ipad_app_store_id = '9010';
		$item->ipad_app_name = 'Electronic Example iPad';
		$item->android_url = 'example-android://electronic/db_1';
		$item->android_package = 'com.electronic.example';
		$item->android_app_name = 'Electronic Example Android';
		$item->windows_phone_url = 'example-windows://electronic/db_1';
		$item->windows_phone_app_id = '64ec0d1b-5b3b-4c77-a86b-5e12d465edc0';
		$item->windows_phone_app_name = 'Electronic Example Windows';
		$item->additional_image_links = [
			'http://images.example.com/DB_1_1.png',
			'http://images.example.com/DB_1_2.png',
			'http://images.example.com/DB_1_3.png',
			'http://images.example.com/DB_1_4.png',
			'http://images.example.com/DB_1_5.png',
			'http://images.example.com/DB_1_6.png',
			'http://images.example.com/DB_1_7.png',
			'http://images.example.com/DB_1_8.png',
			'http://images.example.com/DB_1_9.png',
			'http://images.example.com/DB_1_10.png'
		];
		$item->age_group = 'adult';
		$item->color = 'red';
		$item->expiration_date = '2016-12-23';
		$item->gender = 'male';
		$item->item_group_id = 'DB_GROUP_1';
		$item->material = 'leather';
		$item->pattern = 'some pattern';
		$item->sale_price = '8.30 GBP';
		$item->sale_price_effective_date = '2014-11-01T12:00-0300/2014-12-01T00:00-0300';
		$item->shipping_weight = '10 kg';
		$item->shipping_size = '10x6x8 cm';
		$item->custom_label_0 = 'Made in Waterford, IE (Label 0)';
		$item->custom_label_1 = 'Made in Waterford, IE (Label 1)';
		$item->custom_label_2 = 'Made in Waterford, IE (Label 2)';
		$item->custom_label_3 = 'Made in Waterford, IE (Label 3)';
		$item->custom_label_4 = 'Made in Waterford, IE (Label 4)';

		$item->shippings = [
			$this->shipping(),
			$this->shipping()
		];

		return $item;
	}



	/**
	 * @return Shipping
	 */
	protected function shipping()
	{
		$shipping = new Shipping;

		$shipping->country = 'CZ';
		$shipping->region = null;
		$shipping->postal_code = null;
		$shipping->location_id = null;
		$shipping->location_group_name = null;
		$shipping->service = 'Česká republika';
		$shipping->price = '10 USD';

		return $shipping;
	}

}
