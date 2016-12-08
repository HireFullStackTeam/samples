<?php

namespace App\Contracts\Feed\Factory;

use App\Exceptions\Feed\InvalidFileException;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;



interface FileFactory
{

	/**
	 * @param UploadedFile|File $file
	 * @return \App\Contracts\Feed\File
	 * @throws InvalidFileException
	 */
	public function create($file);
}
