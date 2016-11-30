<?php

namespace Tests\Integration\Validator\Validation\Text;

use App\Feed\Validator\Validation\Text\RequiredFields;
use Tests\TestCase;



class RequiredFieldsTest extends TestCase
{

	/**
	 * @var string[]
	 */
	protected $valid = ['id', 'availability', 'condition', 'description', 'image_link', 'link', 'title', 'price'];

	/**
	 * @var string[]
	 */
	protected $invalid = ['availability', 'condition', 'description', 'image_link', 'link', 'title', 'price'];

	/**
	 * @var string[]
	 */
	protected $invalidMultiple = ['id', 'id', 'availability', 'condition', 'description', 'image_link', 'link', 'title', 'price'];



	/** @test */
	public function it_validates_valid_required()
	{
		$this->assertTrue(
			(new RequiredFields)->validate($this->valid)
		);
	}



	/** @test */
	public function it_validates_invalid_one_missing_required()
	{
		$this->assertFalse(
			(new RequiredFields)->validate($this->invalid)
		);
	}



	/** @test */
	public function it_validates_invalid_multiple_occurrence_required()
	{
		$this->assertFalse(
			(new RequiredFields)->validate($this->invalidMultiple)
		);
	}

}