<?php

namespace App\Gallery\Processors;

use App\Gallery\Support\Dimensions;
use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;



class ImageProcessor extends AbstractProcessor
{

	/**
	 * @var ImageManager
	 */
	protected $manager;



	/**
	 * @param ImageManager $manager
	 */
	public function __construct(ImageManager $manager)
	{
		$this->manager = $manager;
	}



	/**
	 * {@inheritdoc}
	 */
	public function store(UploadedFile $file)
	{
		$path = $file->storeAs(
			$this->path(), $this->fileName($file)
		);

		$image = Dimensions::resize($path);

		return collect()->push(
			$this->imageableFromFactory($path, $image->width(), $image->height())
		);
	}



	/**
	 * @param UploadedFile $file
	 * @return string
	 */
	protected function fileName(UploadedFile $file)
	{
		return time() . '_' . $file->hashName();
	}
}
