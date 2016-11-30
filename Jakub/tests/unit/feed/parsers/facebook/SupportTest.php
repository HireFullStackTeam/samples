<?php

namespace Tests\Unit\Feed\Parsers\Facebook;

use App\Feed\Parsers\Facebook\Structure\Support;
use PHPUnit_Framework_TestCase;



class SupportTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var string[]
	 */
	protected $input = [
		[
			'value'     => '{http://base.google.com/ns/1.0}id',
			'namespace' => 'http://base.google.com/ns/1.0'
		],
		[
			'value'     => '{}id',
			'namespace' => ''
		]
	];

	/*
	 * @var string
	 */
	protected $output = 'id';

	/**
	 * @var string
	 */
	protected $key = 'name';



	/** @test */
	public function it_cleans_named_namespace()
	{
		foreach ($this->input as $input) {
			$this->assertSame(
				$this->toArray($this->output), Support::cleanNamespace($this->toArray($input['value']), $this->key, $input['namespace'])
			);
		}
	}



	/** @test */
	public function it_does_not_clean_with_wrong_name_namespace()
	{
		$result = Support::cleanNamespace($this->toArray($this->input[0]['value']), $this->key);

		$this->assertSameSize($this->toArray($this->output), $result[0]);
		$this->assertNotSame($this->toArray($this->output), $result);
	}



	/** @test */
	public function it_allows_the_namespace_argument_to_be_an_array()
	{
		$namespaces = array_column($this->input, 'namespace');

		$this->input = array_map(function ($input) {
			return ['name' => $input['value']];
		}, $this->input);

		foreach (Support::cleanNamespace($this->input, $this->key, $namespaces) as $array) {
			$this->assertSame($array[$this->key], $this->output);
		}
	}



	/**
	 * @param string $value
	 * @return array
	 */
	protected function toArray($value)
	{
		return [
			[$this->key => $value]
		];
	}
}
