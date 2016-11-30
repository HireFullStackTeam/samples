<?php

namespace Tests\Acceptance\Api\Projects;

use App\Models\Component;
use App\Models\Componentables\Componentable;
use App\Models\Project;
use Tests\TestCase;



class RetrieveProjectsWithComponentsTest extends TestCase
{

	/** @test */
	public function it_retrieves_a_project_with_components()
	{
		$project = factory(Project::class)->create();

		$text = factory(Component::class, 'text')->create([
			'project_id' => $project->id,
			'order'      => 1,
		]);

		$shape = factory(Component::class, 'shape')->create([
			'project_id' => $project->id,
			'order'      => 2,
		]);

		$this->get('/project/' . $project->id)
			->seeJsonEquals([
				'data' => [
					'id'         => $project->id,
					'name'       => $project->name,
					'type'       => [
						'data' => [
							'name'   => $project->type->name,
							'width'  => $project->type->width,
							'height' => $project->type->height,
						],
					],
					'components' => [
						'data' => [
							[
								'id'                 => $text->id,
								'name'               => $text->name,
								'visibility'         => $text->visibility,
								'position_x'         => $text->position_x,
								'position_y'         => $text->position_y,
								'height'             => $text->height,
								'width'              => $text->width,
								'order'              => 1,
								'componentable_type' => Componentable::TEXT,
								'componentable'      => [
									'content' => $text->componentable->content,
									'state'   => $text->componentable->state
								],
							],
							[
								'id'                 => $shape->id,
								'name'               => $shape->name,
								'visibility'         => $shape->visibility,
								'position_x'         => $shape->position_x,
								'position_y'         => $shape->position_y,
								'height'             => $shape->height,
								'width'              => $shape->width,
								'order'              => 2,
								'componentable_type' => Componentable::SHAPE,
								'componentable'      => [
									'shape_id' => $shape->componentable->shape_id,
									'color'    => $shape->componentable->color,
									'content'  => $shape->componentable->content
								],
							],
						],
					],
				],
			]);
	}
}


