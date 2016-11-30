<?php

namespace App\Contracts\Interactions\Components;

use App\Models\Component;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;



interface UpdateComponents
{

	/**
	 * @param array $data
	 * @return Validator
	 */
	public function validator(array $data);



	/**
	 * @param array $data
	 * @return Component[]|Collection
	 */
	public function handle(array $data);
}
