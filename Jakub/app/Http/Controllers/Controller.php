<?php

namespace App\Http\Controllers;

use App\App;
use Dingo\Api\Exception\ValidationHttpException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;



class Controller extends BaseController
{

	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



	/**
	 * Execute the given interaction.
	 *
	 * This performs the common validate and handle flow of some interactions.
	 *
	 * @param  string $interaction
	 * @param  array $parameters
	 * @return mixed
	 */
	protected function interaction($interaction, array $parameters)
	{
		$validator = App::interact($interaction . '@validator', $parameters);

		if ($validator->fails() === true) {
			throw new ValidationHttpException($validator->errors());
		}

		return App::interact($interaction, $parameters);
	}
}
