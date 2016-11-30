<?php

namespace App\Gallery;

use App\Gallery\Support\Dimensions;
use App\Gallery\Support\Position;



class Imageable
{

	/**
	 * @var string
	 */
	protected $path;

	/**
	 * @var Position|null
	 */
	protected $position;

	/**
	 * @var Dimensions|null
	 */
	protected $dimensions;



	/**
	 * @param string $path
	 */
	public function __construct($path)
	{
		$this->path = $path;
	}



	/**
	 * @return string
	 */
	public function path()
	{
		return $this->path;
	}



	/**
	 * @return string
	 */
	public function width()
	{
		return $this->dimensions->width;
	}



	/**
	 * @return string
	 */
	public function height()
	{
		return $this->dimensions->height;
	}



	/**
	 * @return Position|null
	 */
	public function position()
	{
		return $this->position;
	}



	/**
	 * @return Dimensions|null
	 */
	public function dimensions()
	{
		return $this->dimensions;
	}



	/**
	 * @param int $x
	 * @param int $y
	 * @return $this
	 */
	public function setPosition($x, $y)
	{
		$this->position = new Position($x, $y);

		return $this;
	}



	/**
	 * @param int $width
	 * @param int $height
	 * @return $this
	 */
	public function setDimensions($width, $height)
	{
		$this->dimensions = new Dimensions($width, $height);

		return $this;
	}
}
