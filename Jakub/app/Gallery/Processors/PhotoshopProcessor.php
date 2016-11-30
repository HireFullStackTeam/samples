<?php

namespace App\Gallery\Processors;

use App\App;
use App\Gallery\Imageable;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Imagick;



class PhotoshopProcessor extends AbstractProcessor
{

	/**
	 * @var bool
	 */
	protected $skipComposite;

	/**
	 * @var string
	 */
	protected $extension = 'png';

	/**
	 * @var Collection
	 */
	protected $imageables;



	public function __construct()
	{
		$this->imageables = new Collection();
	}



	/**
	 * {@inheritdoc}
	 */
	public function store(UploadedFile $file)
	{
		$imagick = new Imagick($file->path());

		// Only the Imagick can process a photoshop documents.
		// We want to save each layer as an image to the storage.
		// The Imagick is array able, so we can iterate through
		// the imagick to get an access to the all layers.
		foreach ($imagick as $i => $layer) {

			// The very first layer we get is an composite image.
			// This image is make of all layers in the psd file,
			// as you can see in the Photoshop itself.
			// In most use cases we don't want to save this image.
			if ($this->shouldSkipComposite($i)) {
				continue;
			}

			// To get an access to the layer, we have to set this
			// iterator. After that we can make method calls like
			// getImagePage() to get the layer information,
			// like the layer position or the layer dimensions.
			$imagick->setIteratorIndex($i);

			$path = $this->path() . '/' . $this->createFileName();

			if (file_exists($this->path()) === false) {
				mkdir($this->path(), 0777, true);
			}

			// I don't if there is a better way to save an imagick's image
			// to the storage, so we use writeImage method which saves
			// the layer to the storage for us.
			if ($imagick->writeImage($path) === true) {
				$this->imageables->push(
					$this->createImageable($path, $imagick->getImagePage())
				);
			};
		}

		return $this->imageables;
	}



	/**
	 * @param bool $bool
	 * @return $this
	 */
	public function skipComposite(bool $bool)
	{
		$this->skipComposite = $bool;

		return $this;
	}



	/**
	 * @param int $i
	 * @return bool
	 */
	public function shouldSkipComposite(int $i)
	{
		return $this->skipComposite === true && $i === 0;
	}



	/**
	 * @return string
	 */
	protected function path()
	{
		return App::fileSystemStoragePath() . parent::path();
	}



	/**
	 * @return string
	 */
	protected function createFileName()
	{
		return time() . '_' . str_slug(str_random(64)) . '.' . $this->extension;
	}



	/**
	 * @param string $path
	 * @param array $layerInformation
	 * @return Imageable
	 */
	protected function createImageable($path, array $layerInformation)
	{
		// We want to remove an absolute file system storage path to get only
		// a relative path, because we will make intervention's image later
		// from the given relative path.
		$path = Str::replaceFirst(App::fileSystemStoragePath(), '', $path);

		return $this->imageableFromFactory(
			$path, $layerInformation
		);
	}
}
