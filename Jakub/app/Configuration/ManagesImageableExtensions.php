<?php

namespace App\Configuration;

use Illuminate\Support\Arr;



trait ManagesImageableExtensions
{

	/**
	 * @var string[]
	 */
	public static $imageableExtensions = [];



	/**
	 * @return string[]
	 */
	public static function supportedImageableExtensions()
	{
		return self::$imageableExtensions;
	}



	/**
	 * @return string[]
	 */
	public static function imageProcessorExtensions()
	{
		return Arr::except(self::$imageableExtensions, IMAGETYPE_PSD);
	}



	/**
	 * @param string $extension
	 * @return bool
	 */
	public static function isPhotoshopExtension($extension)
	{
		return $extension === self::$imageableExtensions[IMAGETYPE_PSD];
	}



	/**
	 * @param int $extension
	 * @return string
	 */
	public function extension(int $extension)
	{
		return self::$imageableExtensions[$extension];
	}
}
