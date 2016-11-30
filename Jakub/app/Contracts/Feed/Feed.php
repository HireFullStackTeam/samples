<?php

namespace App\Contracts\Feed;

use App\Models\Feed\Product;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;



interface Feed
{

	/**
	 * @param UploadedFile|File $file
	 * @return Product[]|Collection
	 */
	public function handle($file);
}
