<?php

namespace Tests\Integration\Repositories;

use App\Models\Component;
use App\Models\Componentables\Componentable;
use App\Models\Project;
use App\Repositories\ComponentRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Tests\TestCase;



class ComponentRepositoryTest extends TestCase
{

	/** @test */
	public function it_creates_a_component()
	{
		$project = factory(Project::class)->create();
		$type = factory(Project\Type::class)->create();

		$components = new ComponentRepository(new Project());

		$component = $components->create($project, [
			'project_id' => $project->id,
			'type'       => $type->name
		]);

		$this->assertInstanceOf(Component::class, $component);
		$this->assertEquals([
			'order'      => 1,
			'name'       => Str::ucfirst($type->name) . ' 1',
			'project_id' => $project->id
		], Arr::except($component->toArray(), ['id', 'created_at', 'updated_at']));
	}



	/** @test */
	public function it_generates_a_name_for_the_component()
	{
		$project = factory(Project::class)->create();

		factory(Component::class, 'text')->create([
			'project_id' => $project->id
		]);

		$components = new ComponentRepository(new Project());

		$name = $components->generateNameFor($project, Componentable::TEXT);

		$this->assertSame('Text 2', $name);
	}
}
