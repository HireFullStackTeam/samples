<?php

namespace Tests\Integration\Feed\Validator\Validation;

use App\Feed\Validator\TextFileSchema;
use Illuminate\Support\Collection;
use Tests\TestCase;



class TextFileSchemaTest extends TestCase
{

	/**
	 * @var string[]
	 */
	protected $methods = [
		'required' => 'id',
		'optional' => 'ios_url',
		'oneOfs'   => 'gtin',
		'rules'    => 'text'
	];



	/** @test */
	public function it_gets_rules_items_array()
	{
		foreach ($this->methods as $name => $id) {

			/** @var Collection $collection */
			$collection = TextFileSchema::$name();

			$this->assertSame(Collection::class, get_class($collection));

			$itemsArray = $collection->toArray();

			if ($name === 'oneOfs') {
				$itemsArray = $itemsArray[0];
			}

			$this->assertTrue(array_key_exists($id, $itemsArray));
		}
	}
}