<?php

namespace App\Interactions\Feed;

use App\Contracts\Feed\Feed;
use App\Contracts\Interactions\Feed\UploadProductDataFeed as Contract;
use Illuminate\Support\Facades\Validator;



class UploadProductDataFeed implements Contract
{

	/**
	 * @var Feed
	 */
	protected $feed;



	/**
	 * @param Feed $feed
	 */
	public function __construct(Feed $feed)
	{
		$this->feed = $feed;
	}



	/**
	 * @param array $data
	 * @return Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'file' => 'required|file'
		]);
	}



	/**
	 * @param array $data
	 * #return Product[]
	 */
	public function handle(array $data)
	{
		return $this->feed->handle($data['file']);
	}
}
