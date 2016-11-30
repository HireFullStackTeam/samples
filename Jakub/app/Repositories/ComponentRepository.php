<?php

namespace App\Repositories;

use App\Contracts\Repositories\ComponentRepository as Contract;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;



class ComponentRepository implements Contract
{

	/**
	 * @var Project
	 */
	protected $projects;



	/**
	 * @param Project $projects
	 */
	public function __construct(Project $projects)
	{
		$this->projects = $projects;
	}



	/**
	 * {@inheritdoc}
	 */
	public function create(Project $project, array $values)
	{
		$values = array_merge($values, [
			'order' => $this->maxOrder($project),
			'name'  => $this->generateNameFor($project, $values['type'])
		]);

		return $project->components()->create($values);
	}



	/**
	 * {@inheritdoc}
	 */
	public function maxOrder(Project $project)
	{
		return DB::table('components')->where('project_id', $project->id)->max('order') + 1;
	}



	/**
	 * {@inheritdoc}
	 */
	public function generateNameFor(Project $project, $type)
	{
		$components = $project->components()->where('componentable_type', $type)->count();

		return sprintf('%s %d', Str::ucfirst($type), $components + 1);
	}
}
