<?php

namespace Tests\Integration\Transformers;

use App\Models\Componentables\Text;
use App\Transformers\Componentables\TextTransformer;
use Illuminate\Support\Arr;
use Tests\TestCase;



class TextTransformerTest extends TestCase
{

	/**
	 * @var string[]
	 */
	protected $keys = ['content', 'state'];



	/** @test */
	public function it_transforms_text()
	{
		$text = factory(Text::class)->create();

		$this->assertEquals(
			Arr::only($text->toArray(), $this->keys), (new TextTransformer)->transform($text)
		);
	}
}
