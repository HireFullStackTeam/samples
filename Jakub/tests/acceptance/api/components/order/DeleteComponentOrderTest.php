<?php

namespace Tests\Acceptance\Api\Components\Order;

use App\Models\Component;
use App\Models\Project;
use Tests\TestCase;



class DeleteComponentOrderTest extends TestCase
{

	/** @test */
	public function it_deletes_a_component_and_then_checks_for_the_new_order()
	{
		$project = factory(Project::class)->create();

		for ($i = 1; $i <= 4; $i++) {
			$components[$i] = factory(Component::class, 'text')->create([
				'project_id' => $project->id,
				'order'      => $i,
			]);
		}

		$this->delete('/component/' . $components[2]->id);

		$this->seeInDatabase('components', [
			'id'    => $components[1]->id,
			'order' => 1,
		]);

		$this->seeInDatabase('components', [
			'id'    => $components[3]->id,
			'order' => 2,
		]);

		$this->seeInDatabase('components', [
			'id'    => $components[4]->id,
			'order' => 3,
		]);
	}
}
