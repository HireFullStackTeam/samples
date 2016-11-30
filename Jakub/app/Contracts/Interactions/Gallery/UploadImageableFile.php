<?php

namespace App\Contracts\Interactions\Gallery;

use App\Gallery\Support\ResponseCollection;
use App\Models\Project;
use App\Models\User;



interface UploadImageableFile
{

	/**
	 * @param array $data
	 * @param User $user
	 * @param Project $project
	 * @return ResponseCollection
	 */
	public function handle(array $data, User $user, Project $project = null);
}
