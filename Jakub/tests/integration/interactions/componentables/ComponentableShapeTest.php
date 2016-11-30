<?php

namespace Tests\Integration\Interactions\Componentables;

use App\Events\ComponentDeleted;
use App\Feesy\Components\Updates\UpdateManager;
use App\Interactions\Components\CreateComponent;
use App\Interactions\Components\DeleteComponent;
use App\Interactions\Components\UpdateComponent;
use App\Models\Component;
use App\Models\Componentables\Componentable;
use App\Models\Shape;
use Event;
use Faker\Factory;
use Tests\TestCase;



class ComponentableShapeTest extends TestCase
{

	/** @test */
	public function it_creates_componentable_shape()
	{
		$component = factory(Component::class)->make();
		$shape = factory(Shape::class)->create();
		$color = Factory::create()->hexColor;

		$createdComponent = app(CreateComponent::class)->handle(
			array_merge(
				$component->toArray(),
				[
					'type'          => Componentable::SHAPE,
					'componentable' => [
						'shape_id' => $shape->id,
						'color'    => $color,
					],
				]
			)
		);

		$this->seeInDatabase('components', [
			'id'                 => $createdComponent->id,
			'position_x'         => floor(($component->project->type->width - 100) / 2),
			'position_y'         => floor(($component->project->type->height - 100) / 2),
			'width'              => 100,
			'height'             => 100,
			'visibility'         => $component->visibility,
			'componentable_type' => Componentable::SHAPE,
			'componentable_id'   => $createdComponent->componentable->id,
		]);

		$this->seeInDatabase('componentable_shapes', [
			'id'       => $createdComponent->componentable->id,
			'shape_id' => $shape->id,
			'color'    => $color,
		]);
	}



	/** @test */
	public function it_deletes_componentable_shape()
	{
		Event::fake();

		$component = factory(Component::class, 'shape')->create();

		$this->seeInDatabase('components', [
			'id' => $component->id,
		]);

		$this->seeInDatabase('componentable_shapes', [
			'id' => $component->componentable->id,
		]);

		$interaction = new DeleteComponent();
		$interaction->handle($component);

		$this->notSeeInDatabase('components', [
			'id' => $component->id,
		]);

		$this->notSeeInDatabase('componentable_shapes', [
			'id' => $component->componentable->id,
		]);

		Event::assertFired(ComponentDeleted::class, function (ComponentDeleted $event) use ($component) {
			return $component->id === $event->component()->id;
		});
	}



	/** @test */
	public function it_updates_componentable_shape()
	{
		/** @var Component $component */
		$component = factory(Component::class, 'shape')->create([
			'position_x' => 1,
			'position_y' => 2,
			'height'     => 3,
			'width'      => 4,
			'visibility' => true,
		]);

		$componentData = [
			'position_x' => 6671,
			'position_y' => 6672,
			'height'     => 6673,
			'width'      => 6674,
			'visibility' => false,
		];

		$shapeData = [
			'componentable' => [
				'color' => Factory::create()->hexColor,
			],
		];

		$data = array_merge($componentData, $shapeData);

		$interaction = new UpdateComponent(new UpdateManager);
		$interaction->handle($component, $data);

		$this->seeInDatabase('components', array_merge(
			['id' => $component->id], $componentData
		));

		$this->seeInDatabase('componentable_shapes', array_merge(
			['id' => $component->componentable->id], $shapeData['componentable']
		));
	}
}
