<?php

namespace App\Gallery\Processors;

use App\Contracts\Gallery\Factory\ImageableFactory;
use App\Contracts\Gallery\Factory\PhotoshopFactory;
use App\Contracts\Gallery\FileProcessable;
use App\Exceptions\UndefinedFactoryException;
use App\Gallery\Imageable;
use App\Models\User;
use Illuminate\Support\Str;



abstract class AbstractProcessor implements FileProcessable
{

	/**
	 * @var User
	 */
	protected $user;

	/**
	 * @var string
	 */
	protected $directory = 'gallery';

	/**
	 * @var string[]
	 */
	protected $factories = [
		'image'     => ImageableFactory::class,
		'photoshop' => PhotoshopFactory::class,
	];



	/**
	 * @param User $user
	 * @return $this
	 */
	public function forUser(User $user)
	{
		$this->user = $user;

		return $this;
	}



	/**
	 * @param string $path
	 * @param array ...$parameters
	 * @return Imageable
	 */
	protected function imageableFromFactory($path, ...$parameters)
	{
		$factory = app($this->resolveFactory());

		return $factory->build($path, ...$parameters);
	}



	/**
	 * @return string
	 */
	protected function path()
	{
		return rtrim($this->directory, '/') . '/' . $this->user->id;
	}



	/**
	 * @throws UndefinedFactoryException
	 * @return string
	 */
	protected function resolveFactory()
	{
		$factory = Str::replaceFirst('processor', '', Str::lower(class_basename($this)));

		if (isset($this->factories[$factory]) === false) {
			throw new UndefinedFactoryException($factory);
		}

		return $this->factories[$factory];
	}
}
