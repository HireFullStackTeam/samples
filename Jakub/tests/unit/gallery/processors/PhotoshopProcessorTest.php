<?php

namespace Tests\Unit\Gallery\Processor;

use App\Gallery\Processors\PhotoshopProcessor;
use PHPUnit_Framework_TestCase;



class PhotoshopProcessorTest extends PHPUnit_Framework_TestCase
{

	/** @test */
	public function it_skips_first_layer()
	{
		$processor = new PhotoshopProcessor;

		$processor->skipComposite(true);

		$this->assertTrue($processor->shouldSkipComposite(0));
		$this->assertFalse($processor->shouldSkipComposite(1));
	}



	/** @test */
	public function it_not_skips_first_layer()
	{
		$processor = new PhotoshopProcessor;

		$processor->skipComposite(false);

		$this->assertFalse($processor->shouldSkipComposite(0));
		$this->assertFalse($processor->shouldSkipComposite(1));
	}
}