<?php

namespace App\Models\Componentables;


use Exception;



interface Componentable
{

	const TEXT = 'text';
	const SHAPE = 'shape';
	const IMAGE = 'image';

	const ALL = [
		self::TEXT, self::SHAPE, self::IMAGE
	];



	/**
	 * @param  array $attributes
	 * @param  array $options
	 * @return bool
	 */
	public function update(array $attributes = [], array $options = []);



	/**
	 * @return bool|null
	 *
	 * @throws Exception
	 */
	public function delete();
}
