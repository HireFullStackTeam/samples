<?php

namespace Tests\Support;

use Illuminate\Http\UploadedFile as IlluminateUploadedFile;



class UploadedFile extends IlluminateUploadedFile
{

	/**
	 * @param string $path
	 * @return UploadedFile
	 */
	public static function makeFrom($path)
	{
		$path = base_path($path);
		$filename = str_slug(str_random());
		$mime = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $path);

		return new static($path, $filename, $mime, null, null, true);
	}
}
