<?php

namespace App\Repositories\Gallery;

use App\Contracts\Repositories\Gallery\ImageRepository as Contract;
use App\Gallery\Imageable;
use App\Models\Gallery\Image;
use App\Models\Project;
use App\Models\User;



class ImageRepository implements Contract
{

	/**
	 * @var Image
	 */
	protected $images;



	/**
	 * @param Image $images
	 */
	public function __construct(Image $images)
	{
		$this->images = $images;
	}



	/**
	 * {@inheritdoc}
	 */
	public function create(Imageable $imageable, User $user, Project $project = null)
	{
		$image = $this->images->create([
			'user_id' => $user->id,
			'path'    => $imageable->path(),
			'width'   => $imageable->width(),
			'height'  => $imageable->height(),
		]);

		if ($project !== null) {
			$image->project()->associate($project)->save();
		}

		return $image;
	}
}
