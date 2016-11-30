<?php

namespace App\Contracts\Repositories\Gallery;

use App\Gallery\Imageable;
use App\Models\Gallery\Image;
use App\Models\Project;
use App\Models\User;



interface ImageRepository
{

	/**
	 * @param Imageable $imageable
	 * @param User $user
	 * @param Project|null $project
	 * @return Image
	 */
	public function create(Imageable $imageable, User $user, Project $project = null);
}
