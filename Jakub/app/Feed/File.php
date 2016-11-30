<?php

namespace App\Feed;

use App\Contracts\Feed\File as Contract;
use App\Exceptions\Feed\InvalidFileException;
use Illuminate\Http\File as IlluminateFile;
use Illuminate\Http\UploadedFile;



class File implements Contract
{

	/**
	 * @var IlluminateFile|UploadedFile
	 */
	protected $file;



	/**
	 * @param IlluminateFile|UploadedFile $file
	 */
	public function __construct($file)
	{
		if (!($file instanceof IlluminateFile) && !($file instanceof UploadedFile)) {
			throw new InvalidFileException($file);
		}

		$this->file = $file;
	}



	/**
	 * {@inheritdoc}
	 */
	public function path()
	{
		return $this->file->path();
	}



	/**
	 * {@inheritdoc}
	 */
	public function extension()
	{
		return $this->file->extension();
	}



	/**
	 * {@inheritdoc}
	 */
	public function originalFile()
	{
		return $this->file;
	}
}
