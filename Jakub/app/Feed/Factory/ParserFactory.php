<?php

namespace App\Feed\Factory;

use App\Contracts\Feed\Factory\ParserFactory as Contract;
use App\Contracts\Feed\File;
use App\Contracts\Feed\Mapper;
use App\Contracts\Feed\Parser;
use App\Exceptions\UnsupportedFileExtensionException;



class ParserFactory implements Contract
{

	/**
	 * @var Parser[]
	 */
	protected $parsers = [];

	/**
	 * @var Mapper[]
	 */
	protected $mappers = [];



	/**
	 * @param array $parsers
	 * @param array $mappers
	 */
	public function __construct(array $parsers, array $mappers)
	{
		$this->parsers = $parsers;
		$this->mappers = $mappers;
	}



	/**
	 * {@inheritdoc}
	 */
	public function create(File $file)
	{
		foreach ($this->fetchParsersForExtension($file->extension()) as $parser) {
			if ($parser->match($file->path())) {

				// If there is registered a mapper for the parser, register it.
				if ($mapper = $this->mapperExistsFor($parser)) {
					$parser->registerMapper($mapper);
				}

				return $parser;
			}
		}

		return null;
	}



	/**
	 * @param Parser $parser
	 * @return \App\Contracts\Feed\Mapper|false
	 */
	protected function mapperExistsFor(Parser $parser)
	{
		if (isset($this->mappers[get_class($parser)])) {
			return app($this->mappers[get_class($parser)]);
		}

		return false;
	}



	/**
	 * @param string $extension
	 * @return Parser[]
	 * @throws UnsupportedFileExtensionException
	 */
	protected function fetchParsersForExtension($extension)
	{
		if (isset($this->parsers[$extension]) === false) {
			throw new UnsupportedFileExtensionException($extension);
		}

		return array_map('app', $this->parsers[$extension]);
	}
}
