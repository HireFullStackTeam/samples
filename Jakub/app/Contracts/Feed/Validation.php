<?php

namespace App\Contracts\Feed;

interface Validation
{

	/**
	 * @param array $header
	 * @return bool
	 */
	public function validate(array $header);
}
