<?php

namespace App\Feed\Parsers;

use App\Feed\Parsers\Facebook\Structure\Item;
use App\Feed\Validator\TextValidator;
use Iterator;
use League\Csv\Reader;



abstract class TextParser extends AbstractParser
{

	/**
	 * {@inheritdoc}
	 */
	public function parse($path)
	{
		foreach ($this->read($path) as $values) {
			array_push(
				$this->items, $this->parseAdditionalImageLinks(Item::create($values), $values)
			);
		}

		return $this;
	}



	/**
	 * {@inheritdoc}
	 */
	public function match($path)
	{
		if ($this->validateFileDelimiter($path) === false) {
			return false;
		};

		return app(TextValidator::class)->validate($path, $this->delimiter) === false;
	}



	/**
	 * @param string $path
	 * @return Iterator
	 */
	protected function read($path)
	{
		return Reader::createFromPath($path)
			->setDelimiter($this->delimiter)
			->fetchAssoc();
	}



	/**
	 * @param string $filePath
	 * @return bool
	 */
	protected function validateFileDelimiter($filePath)
	{
		return TextFileDelimiter::check($filePath)->against($this->delimiter);
	}



	/**
	 * @param Item  $item
	 * @param array $values
	 * @return Item
	 */
	protected function parseAdditionalImageLinks(Item $item, $values)
	{
		if (isset($values['additional_image_link']) === true) {
			$item->additional_image_links = explode(',', $values['additional_image_link']);
		}

		return $item;
	}
}
