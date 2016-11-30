<?php

namespace App\Gallery\Support;

class Position
{

	/**
	 * @var int
	 */
	public $x;

	/**
	 * @var int
	 */
	public $y;



	/**
	 * @param int $x
	 * @param int $y
	 */
	public function __construct($x, $y)
	{
		$this->x = (int) $x;
		$this->y = (int) $y;
	}
}
