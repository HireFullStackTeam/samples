<?php

namespace Tests\Integration\Interactions\Components;

use App\Contracts\Repositories\ComponentRepository;
use App\Feesy\Components\Factories\ComponentableFactory;
use App\Interactions\Components\CreateComponent;
use App\Models\Component;
use App\Models\Componentables\Componentable;
use App\Models\Gallery\Image;
use App\Models\Project;
use Prophecy\Prophecy\ObjectProphecy;
use Tests\TestCase;



class CreateImageComponentTest extends TestCase
{

	/** @test */
	public function it_calculates_correct_componentable_dimensions()
	{
		foreach ($this->fixtures() as $fixture) {
			$component = $this->createComponentBy($fixture);

			$this->assertInstanceOf(Component::class, $component);
			$this->assertInstanceOf(\App\Models\Componentables\Image::class, $component->componentable);

			$this->assertSame($component->width, $fixture['component'][0]);
			$this->assertSame($component->height, $fixture['component'][1]);
		}
	}



	/**
	 * @param Image $image
	 * @return CreateComponent
	 */
	protected function interaction(Image $image)
	{
		return new CreateComponent(
			app(ComponentRepository::class), new Project(), $this->mockComponentableFactory($image)->reveal()
		);
	}



	/**
	 * @param array $fixture
	 * @return Component
	 */
	protected function createComponentBy(array $fixture)
	{
		$type = factory(Project\Type::class)->create([
			'width'  => $fixture['type'][0],
			'height' => $fixture['type'][1]
		]);

		$image = factory(Image::class)->create([
			'width'      => $fixture['image'][0],
			'height'     => $fixture['image'][1],
			'project_id' => factory(Project::class)->create([
				'type_id' => $type->id
			])->id
		]);

		return $this->interaction($image)->handle([
			'type'          => Componentable::IMAGE,
			'project_id'    => $image->project->id,
			'componentable' => [
				'image_id' => $image->id
			]
		]);
	}



	/**
	 * @param Image $image
	 * @return ComponentableFactory|ObjectProphecy
	 */
	protected function mockComponentableFactory(Image $image)
	{
		$factory = $this->prophesize(ComponentableFactory::class);

		$factory->create(Componentable::IMAGE, ['image_id' => $image->id])
			->shouldBeCalled()
			->willReturn(
				factory(\App\Models\Componentables\Image::class)->create([
					'width'  => $image->width,
					'height' => $image->height
				])
			);

		return $factory;
	}



	/**
	 * @return array
	 */
	protected function fixtures()
	{
		return require __DIR__ . '/fixtures/dimensions.php';
	}
}
