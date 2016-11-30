<?php

namespace Tests\Acceptance\Api\Components;

use App\Models\Component;
use App\Models\Project;
use Tests\TestCase;



class UpdateComponentsTest extends TestCase
{

	/** @test */
	public function it_updates_two_components()
	{
		$project = factory(Project::class)->create();

		$components = [
			'text'  => factory(Component::class, 'text')->create([
				'project_id' => $project->id,
				'order'      => 1,
			]),
			'shape' => factory(Component::class, 'shape')->create([
				'project_id' => $project->id,
				'order'      => 2,
			])
		];

		$updates = $this->getDataForUpdate($components);

		$this->put('/components', [
			'components' => $updates
		]);

		$this->seeJson([
			'data' => [
				$this->transformToExpectedResponse($updates['text'], 'text'),
				$this->transformToExpectedResponse($updates['shape'], 'shape', $components['shape']->componentable->shape_id)
			]
		]);
	}



	/** @test */
	public function it_returns_exception_if_only_updates_component_width()
	{
		$component = factory(Component::class, 'text')->create();

		$this->put('/components', [
			'components' => [
				[
					'id'    => $component->id,
					'width' => 100
				]
			]
		]);

		$this->seeJsonContains([
			'status_code' => 422
		]);
	}



	/** @test */
	public function it_returns_exception_when_updates_nonexistent_component()
	{
		$this->put('/components', [
			'components' => [
				[
					'id'     => 1000,
					'width'  => 1,
					'height' => 2
				]
			]
		]);

		$this->seeJsonContains([
			'status_code' => 422
		]);
	}



	/**
	 * @param string[] $data
	 * @param string   $type
	 * @param string   $shapeId
	 * @return array
	 */
	protected function transformToExpectedResponse($data, $type = null, $shapeId = null)
	{
		if ($shapeId !== null) {
			$data['componentable']['shape_id'] = $shapeId;
		}

		if ($type !== null) {
			$data['componentable_type'] = $type;
		}

		return $data;
	}



	/**
	 * @param array $components
	 * @return array
	 */
	protected function getDataForUpdate($components)
	{
		return [
			'text'  => [
				'id'            => $components['text']->id,
				'name'          => 'Text',
				'visibility'    => false,
				'position_x'    => 11,
				'position_y'    => 12,
				'height'        => 13,
				'width'         => 14,
				'order'         => 2,
				'componentable' => [
					'content' => 'text',
					'state'   => 'state'
				]
			],
			'shape' => [
				'id'            => $components['shape']->id,
				'name'          => 'Shape',
				'visibility'    => false,
				'position_x'    => 21,
				'position_y'    => 22,
				'height'        => 23,
				'width'         => 24,
				'order'         => 1,
				'componentable' => [
					'color'   => 'red',
					'content' => $components['shape']->componentable->content
				]
			]
		];
	}

}
