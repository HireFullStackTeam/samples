<?php

namespace App\Feed\Validator;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;



class TextFileSchema
{

	/**
	 * @var string
	 */
	public $content;

	/**
	 * @var TextFileSchema
	 */
	private static $instance;



	protected function __construct()
	{
		// TODO encapsulate
		$this->content = json_decode(File::get(storage_path('app/feed/schema/string.json')), true);
	}



	/**
	 * @return Collection
	 */
	public static function required()
	{
		return collect(self::instance()->content['required']);
	}



	/**
	 * @return Collection
	 */
	public static function optional()
	{
		return collect(self::instance()->content['optional']);
	}



	/**
	 * @return Collection
	 */
	public static function oneOfs()
	{
		return collect(self::instance()->content['oneofs']);
	}

	/**
	 * @return Collection
	 */
	public static function rules()
	{
		return collect(self::instance()->content['rules']);
	}


	/**
	 * @return TextFileSchema
	 */
	protected static function instance()
	{
		if (self::$instance === null) {
			self::$instance = new self;
		}

		return self::$instance;
	}
}
