<?php

namespace Tests\Integration\Repositories;

use App\Models\Feed\Product;
use App\Repositories\Products\DatabaseProductRepository;
use Carbon\Carbon;
use Tests\TestCase;



class DatabaseProductRepositoryTest extends TestCase
{

	/*
	 * $var DatabaseProductRepository
	 */
	protected $repository;



	public function setUp()
	{
		parent::setUp();

		$this->repository = new DatabaseProductRepository(new Product());
	}



	/** @test */
	public function it_inserts_products_from_arrey()
	{
		$this->repository->createFromCollection(
			$expected = $this->data()
		);

		$this->seeInDatabase('products', [
			'external_id' => $expected[0]['external_id'],
			'external_id' => $expected[1]['external_id'],
		]);
	}



	/** @test */
	public function it_inserts_products_from_collection()
	{
		$this->repository->createFromCollection(
			$expected = collect($this->data('collection'))
		);

		$this->seeInDatabase('products', [
			'external_id' => $expected[0]['external_id'],
			'external_id' => $expected[1]['external_id'],
		]);
	}



	/**
	 * @return array
	 */
	protected function data()
	{
		$carbon = Carbon::now();

		$data = [
			[
				"external_id"  => str_random(32),
				"title"        => "Dog Bowl In Blue",
				"price"        => 9.99,
				"link"         => "http://www.example.com/bowls/db-1.html",
				"image_link"   => "http://images.example.com/DB_1.png",
				"condition"    => "new",
				"availability" => "in stock",
				"created_at"   => $carbon,
				"updated_at"   => $carbon
			],
			[
				"external_id"  => str_random(32),
				"title"        => "Dog Bowl In Blue",
				"price"        => 9.99,
				"link"         => "http://www.example.com/bowls/db-1.html",
				"image_link"   => "http://images.example.com/DB_1.png",
				"condition"    => "new",
				"availability" => "in stock",
				"created_at"   => $carbon,
				"updated_at"   => $carbon
			]
		];

		return $data;
	}

}