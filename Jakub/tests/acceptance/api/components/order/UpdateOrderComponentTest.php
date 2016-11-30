<?php

namespace Tests\Acceptance\Api\Components\Order;

use App\Models\Component;
use App\Models\Project;
use Tests\TestCase;



class UpdateOrderComponentTest extends TestCase
{

	/**
	 * @var Component[]
	 */
	protected $components = [];

	/**
	 * @var int
	 */
	protected static $componentsCount = 5;



	public function setUp()
	{
		parent::setUp();

		$project = factory(Project::class)->create();

		for ($i = 1; $i <= self::$componentsCount; $i++) {
			$this->components[$i] = $this->createComponentWithOrder($project, $i);
		}
	}



	/** @test */
	public function it_changes_order_forward()
	{
		$this->patch('/component/' . $this->components[4]->id, [
			'order' => 2,
		]);

		$this->checkComponentOrder($this->components[1], 1);
		$this->checkComponentOrder($this->components[4], 2);
		$this->checkComponentOrder($this->components[2], 3);
		$this->checkComponentOrder($this->components[3], 4);
		$this->checkComponentOrder($this->components[5], 5);
	}



	/** @test */
	public function it_changes_order_backward()
	{
		$this->patch('/component/' . $this->components[2]->id, [
			'order' => 4,
		]);

		$this->checkComponentOrder($this->components[1], 1);
		$this->checkComponentOrder($this->components[3], 2);
		$this->checkComponentOrder($this->components[4], 3);
		$this->checkComponentOrder($this->components[2], 4);
		$this->checkComponentOrder($this->components[5], 5);
	}



	/** @test */
	public function it_changes_order_more_than_number_of_components_should_not_change_order()
	{
		$this->patch('/component/' . $this->components[2]->id, [
			'order' => 1000000,
		]);

		$this->checkComponentOrder($this->components[1], 1);
		$this->checkComponentOrder($this->components[2], 2);
		$this->checkComponentOrder($this->components[3], 3);
		$this->checkComponentOrder($this->components[4], 4);
		$this->checkComponentOrder($this->components[5], 5);
	}



	/**
	 * @param Project $project
	 * @param int $order
	 * @return Component
	 */
	protected function createComponentWithOrder(Project $project, $order)
	{
		$component = factory(Component::class)->create([
			'project_id' => $project->id,
			'order'      => $order,
		]);

		return $component;
	}



	/**
	 * @param Component $component
	 * @param int $order
	 */
	protected function checkComponentOrder(Component $component, $order)
	{
		$this->seeInDatabase('components', [
			'id'    => $component->id,
			'order' => $order,
		]);
	}

}
