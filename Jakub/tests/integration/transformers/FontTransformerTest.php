<?php

namespace Tests\Integration\Transformers;

use App\Models\Font;
use App\Transformers\FontTransformer;
use Illuminate\Support\Arr;
use Tests\TestCase;



class FontTransformerTest extends TestCase
{

	/**
	 * @var string[]
	 */
	protected $exclude = [
		'updated_at',
		'created_at',
	];



	/** @test */
	public function it_transforms_font()
	{
		$font = factory(Font::class)->create();

		$this->assertEquals(
			Arr::except($font->toArray(), $this->exclude), (new FontTransformer)->transform($font)
		);
	}
}
