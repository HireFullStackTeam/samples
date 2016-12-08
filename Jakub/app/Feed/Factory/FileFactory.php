<?php

namespace App\Feed\Factory;

use App\Contracts\Feed\Factory\FileFactory as Contract;
use App\Contracts\Feed\File;
use App\Exceptions\Feed\InvalidFileException;
use App\Feed\File\IlluminateFileAdapter;
use App\Feed\File\UploadedFileAdapter;
use Illuminate\Http\File as IlluminateFile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;



class FileFactory implements Contract
{

	/**
	 * {@inheritdoc}
	 */
	public function create($file)
	{
		$method = 'create' . Str::studly(class_basename($file)) . 'Adapter';

		if (method_exists($this, $method)) {
			return $this->$method($file);
		}

		throw new InvalidFileException($file);
	}



	/**
	 * @param UploadedFile $file
	 * @return File
	 */
	public function createUploadedFileAdapter(UploadedFile $file)
	{
		return new UploadedFileAdapter($file);
	}



	/**
	 * @param IlluminateFile $file
	 * @return File
	 */
	public function createFileAdapter(IlluminateFile $file)
	{
		return new IlluminateFileAdapter($file);
	}
}
