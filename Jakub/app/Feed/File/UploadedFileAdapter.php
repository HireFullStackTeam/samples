<?php

namespace App\Feed\File;

use App\Contracts\Feed\File;
use Illuminate\Http\UploadedFile;



class UploadedFileAdapter implements File
{

	/**
	 * @var UploadedFile
	 */
	protected $file;



	/**
	 * @param UploadedFile $file
	 */
	public function __construct(UploadedFile $file)
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
	 * @return UploadedFile
	 */
	public function originalFile()
	{
		return $this->file;
	}
}
