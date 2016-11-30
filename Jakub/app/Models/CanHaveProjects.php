<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;



trait CanHaveProjects
{

	/**
	 * @return HasMany
	 */
	public function projects()
	{
		return $this->hasMany(Project::class);
	}



	/**
	 * @param  Project $project
	 * @return bool
	 */
	public function ownsProject(Project $project)
	{
		return $this->id && $this->id == $project->user_id;
	}
}
