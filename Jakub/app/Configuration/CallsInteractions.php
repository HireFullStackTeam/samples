<?php

namespace App\Configuration;

use Illuminate\Support\Str;



trait CallsInteractions
{

	/**
	 * @param  string $interaction
	 * @param  array $parameters
	 * @return mixed
	 */
	public static function interact($interaction, array $parameters = [])
	{
		if (Str::contains($interaction, '@') === false) {
			$interaction = $interaction . '@handle';
		}

		list($class, $method) = explode('@', $interaction);

		return call_user_func_array([app($class), $method], $parameters);
	}

}
