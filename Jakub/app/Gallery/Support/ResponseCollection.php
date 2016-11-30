<?php

namespace App\Gallery\Support;

use App\Models\Component;
use App\Models\Gallery\Image;
use Illuminate\Support\Collection;



class ResponseCollection
{

	/**
	 * @var Collection
	 */
	protected $images;

	/**
	 * @var Collection
	 */
	protected $components;



	public function __construct()
	{
		$this->images = new Collection();
		$this->components = new Collection();
	}



	/**
	 * @param Image $image
	 */
	public function addImage(Image $image)
	{
		$this->images->push($image);
	}



	/**
	 * @param Component $component
	 */
	public function addComponent(Component $component)
	{
		$this->components->push($component);
	}



	/**
	 * @return Collection
	 */
	public function images()
	{
		return $this->images;
	}



	/**
	 * @return Collection
	 */
	public function components()
	{
		return $this->components;
	}
}
