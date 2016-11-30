<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Interactions\Feed\UploadProductDataFeed;
use Illuminate\Http\File;
use Illuminate\Http\Request;



class FeedController extends ApiController
{

	/**
	 * @param Request $request
	 */
	public function store(Request $request)
	{
		$this->interaction(UploadProductDataFeed::class, [
			$request->all(),
		]);
	}



	/**
	 * @param string $provider
	 * @param string $extension
	 */
	public function test($provider, $extension)
	{
		$files = [
			'facebook' => [
				'atom' => 'app/feed/examples/13466573_1738414983069642_1284757774_n.xml',
				'rss'  => 'app/feed/examples/bewooden_facebook_30-09-2016_cz_one.xml',
				'csv'  => 'app/feed/examples/bw.csv',
				'tsv'  => 'app/feed/examples/13438471_503145803225234_731524223_n.tsv'
			]
		];

		app(\App\Interactions\Feed\UploadProductDataFeed::class)->handle([
			'file' => new File(storage_path($files[$provider][$extension]))
		]);
	}
}
