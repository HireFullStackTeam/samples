<?php

namespace App\Interactions\Components;

use App\App;
use App\Contracts\Interactions\Components\CreateComponent as Contract;
use App\Contracts\Repositories\ComponentRepository;
use App\Feesy\Components\Factories\ComponentableFactory;
use App\Models\Component;
use App\Models\Componentables\Componentable;
use App\Models\Componentables\Image;
use App\Models\Project;
use App\Support\Dimensions;
use Closure;



class CreateComponent implements Contract
{

	/**
	 * @var ComponentRepository
	 */
	protected $components;

	/**
	 * @var Project
	 */
	protected $projects;

	/**
	 * @var ComponentableFactory
	 */
	protected $factory;



	/**
	 * @param ComponentRepository  $components
	 * @param Project              $projects
	 * @param ComponentableFactory $factory
	 */
	public function __construct(
		ComponentRepository $components,
		Project $projects,
		ComponentableFactory $factory
	) {
		$this->components = $components;
		$this->projects = $projects;
		$this->factory = $factory;
	}



	/**
	 * {@inheritdoc}
	 */
	public function handle(array $data)
	{
		$componentable = $this->createComponentable($data);

		$componentable->component()->save(
			$component = $this->createComponent($data, function (Project $project) use ($componentable) {
				return $this->placement($project, $componentable);
			})
		);

		$componentable->save();

		return $component;
	}



	/**
	 * @param array $data
	 * @return Componentable
	 */
	protected function createComponentable(array $data)
	{
		return $this->factory->create(
			$data['type'], $data['componentable'] ?? []
		);
	}



	/**
	 * @param array   $values
	 * @param Closure $callback
	 * @return Component
	 */
	protected function createComponent(array $values, Closure $callback)
	{
		$project = $this->projects->find($values['project_id']);

		// Use this callback to merge an additional values for the component
		$values = array_merge($values, $callback($project));

		return $this->components->create($project, $values);
	}



	/**
	 * @param Project       $project
	 * @param Componentable $componentable
	 * @return array
	 */
	protected function placement(Project $project, Componentable $componentable)
	{
		$dimensions = $this->dimensions($componentable, $project->type);

		$position = [
			'position_x' => floor(($project->type->width - $dimensions->width()) / 2),
			'position_y' => floor(($project->type->height - $dimensions->height()) / 2)
		];

		return array_merge($dimensions->toArray(), $position);
	}



	/**
	 * @param Componentable $componentable
	 * @param Project\Type  $type
	 * @return Dimensions
	 */
	protected function dimensions(Componentable $componentable, Project\Type $type)
	{
		if ($componentable instanceof Image) {
			if ($componentable->width < $type->width && $componentable->height < $type->height) {
				return Dimensions::create($componentable->width, $componentable->height);
			}

			if ($componentable->width >= $componentable->height) {
				return $this->proportionallyResizedDimensions('width', 'height', $componentable, $type);

			} else {
				return $this->proportionallyResizedDimensions('height', 'width', $componentable, $type);
			}
		}

		return App::dimensionsFor(get_class($componentable));
	}



	/**
	 * @param string        $primary
	 * @param string        $secondary
	 * @param Componentable $componentable
	 * @param Project\Type  $type
	 * @return Dimensions
	 */
	protected function proportionallyResizedDimensions($primary, $secondary, Componentable $componentable, Project\Type $type)
	{
		$dimensions = [];

		// We have to ensure that an resized image primary dimension is not bigger than type itself
		$dimensions[$primary] = min($componentable->$primary, $type->$primary);

		// Then we need to calculate the ratio to proportionally resize the image
		$ratio = $dimensions[$primary] / $componentable->$primary;

		// Apply the ration to the secondary dimension
		$dimensions[$secondary] = $componentable->$secondary * $ratio;

		// And return the dimensions as an object
		return Dimensions::create($dimensions['width'], $dimensions['height']);
	}
}
