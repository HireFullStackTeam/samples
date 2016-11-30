<?php

namespace App\Contracts\Feed;

use Illuminate\Http\File as IlluminateFile;
use Illuminate\Http\UploadedFile;



interface File
{

	/**
	 * @return string
	 */
	public function path();



	/**
	 * @return string
	 */
	public function extension();



	/**
	 * @return IlluminateFile|UploadedFile
	 */
	public function originalFile();
}
