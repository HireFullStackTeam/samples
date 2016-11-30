<?php

namespace Tests\Integration\Validator\Validation\Text;

use App\Feed\Validator\Validation\Text\OneOfs;
use Tests\TestCase;



class OneOfsTest extends TestCase
{

	/**
	 * @var string[]
	 */
	protected $validOne = [
		'brand'
	];

	/**
	 * @var string[]
	 */
	protected $validAll = [
		'gtin',
		'mpn',
		'brand'
	];

	/**
	 * @var array
	 */
	protected $invalid = [];



	/** @test */
	public function it_validates_valid_oneofs_one_item_given()
	{
		$this->assertTrue((new OneOfs)->validate($this->validOne));
	}



	/** @test */
	public function it_validates_valid_oneofs_all_items_given()
	{
		$this->assertTrue((new OneOfs)->validate($this->validAll));
	}



	/** @test */
	public function it_validates_invalid_oneofs()
	{
		$this->assertFalse((new OneOfs)->validate($this->invalid));
	}
}