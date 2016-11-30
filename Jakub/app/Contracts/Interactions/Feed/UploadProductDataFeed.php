<?php

namespace App\Contracts\Interactions\Feed;

use Illuminate\Support\Facades\Validator;



interface UploadProductDataFeed
{

	/**
	 * @param array $data
	 * @return Validator
	 */
	public function validator(array $data);



	/**
	 * @param array $data
	 */
	public function handle(array $data);
}
