<?php

namespace App\Validation;

use App\Models\Project;
use App\Models\User;
use Illuminate\Validation\Validator;



trait UserHasToOwnProjectValidation
{

	/**
	 * @param Validator $validator
	 * @param User $user
	 * @param Project $project
	 */
	protected function validateUserOwnsProject(Validator $validator, User $user, Project $project)
	{
		if ($user->ownsProject($project) === false) {
			$validator->errors()->add('project_id', 'The user has to own the project.');
		}
	}
}
