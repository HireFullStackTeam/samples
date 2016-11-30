<?php

namespace App\Contracts\Repositories;

use App\Models\Component;
use App\Models\Project;



interface ComponentRepository
{

	/**
	 * @param Project $project
	 * @param array   $values
	 * @return Component
	 */
	public function create(Project $project, array $values);



	/**
	 * @param Project $project
	 * @return int
	 */
	public function maxOrder(Project $project);



	/**
	 * @param Project $project
	 * @param string  $type
	 * @return int
	 */
	public function generateNameFor(Project $project, $type);
}
