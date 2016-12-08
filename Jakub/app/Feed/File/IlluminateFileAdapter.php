<?php

namespace App\Feed\File;

use App\Contracts\Feed\File;
use Illuminate\Http\File as IlluminateFile;
use Illuminate\Http\UploadedFile;



class IlluminateFileAdapter implements File
{

	/**
	 * @var UploadedFile
	 */
	protected $file;



	/**
	 * @param IlluminateFile $file
	 */
	public function __construct(IlluminateFile $file)
	{
		$this->file = $file;
	}



	/**
	 * @return string
	 */
	public function path()
	{
		return $this->file->path();
	}



	/**
	 * @return string
	 */
	public function extension()
	{
		return $this->file->extension();
	}



	/**
	 * @return IlluminateFile
	 */
	public function originalFile()
	{
		return $this->file;
	}
}
