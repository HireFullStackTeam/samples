<?php

namespace App\Contracts\Repositories;

use App\Models\Project;
use App\Models\Project\Type;
use App\Models\User;



interface ProjectRepository
{

	/**
	 * @param User $user
	 * @param Type $type
	 * @param string $name
	 * @return Project
	 */
	public function create(User $user, Type $type, $name);



	/**
	 * @param Project $project
	 * @param array $data
	 * @return Project
	 */
	public function update(Project $project, array $data);
}
