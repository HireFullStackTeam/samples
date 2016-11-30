<?php
namespace Tests\Integration\Interactions\Componentables;


use App\App;
use App\Events\ComponentDeleted;
use App\Feesy\Components\Updates\UpdateManager;
use App\Interactions\Components\CreateComponent;
use App\Interactions\Components\DeleteComponent;
use App\Interactions\Components\UpdateComponent;
use App\Models\Component;
use App\Models\Componentables\Componentable;
use App\Models\Componentables\Text;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;



class ComponentableTextTest extends TestCase
{

	/** @test */
	public function it_creates_componentable_text()
	{
		$component = factory(Component::class)->make();

		$interaction = app(CreateComponent::class);

		$data = [
			'content' => str_random(50),
			'state'   => str_random(50),
		];

		$createdComponent = $interaction->handle(
			array_merge(
				$component->toArray(),
				[
					'type'          => Componentable::TEXT,
					'componentable' => $data,
				]
			)
		);

		$this->seeInDatabase('components', [
			'id'                 => $createdComponent->id,
			'position_x'         => floor(($createdComponent->project->type->width - App::dimensionsFor(Text::class)->width()) / 2),
			'position_y'         => floor(($createdComponent->project->type->height - App::dimensionsFor(Text::class)->height()) / 2),
			'width'              => App::dimensionsFor(Text::class)->width(),
			'height'             => App::dimensionsFor(Text::class)->height(),
			'visibility'         => $component->visibility,
			'componentable_type' => Componentable::TEXT,
			'componentable_id'   => $createdComponent->componentable->id,
		]);

		$this->seeInDatabase('componentable_texts', [
			'id'      => $createdComponent->componentable->id,
			'content' => $data['content'],
			'state'   => $data['state']
		]);
	}



	/** @test */
	public function it_deletes_componentable_text()
	{
		Event::fake();

		$component = factory(Component::class, 'text')->create();

		$this->seeInDatabase('components', [
			'id' => $component->id,
		]);

		$this->seeInDatabase('componentable_texts', [
			'id' => $component->componentable->id,
		]);

		$interaction = new DeleteComponent();
		$interaction->handle($component);

		$this->notSeeInDatabase('components', [
			'id' => $component->id,
		]);

		$this->notSeeInDatabase('componentable_texts', [
			'id' => $component->componentable->id,
		]);

		Event::assertFired(ComponentDeleted::class, function (ComponentDeleted $event) use ($component) {
			return $component->id === $event->component()->id;
		});
	}



	/** @test */
	public function it_updates_componentable_text()
	{
		$component = factory(Component::class, 'text')->create([
			'position_x' => 1,
			'position_y' => 2,
			'height'     => 3,
			'width'      => 4,
			'visibility' => true,
		]);

		$componentData = [
			'position_x' => 6661,
			'position_y' => 6662,
			'height'     => 6663,
			'width'      => 6664,
			'visibility' => false,
		];

		$textData = [
			'componentable' => [
				'content' => str_random(60),
			],
		];

		$data = array_merge($componentData, $textData);

		$interaction = new UpdateComponent(new UpdateManager);
		$interaction->handle($component, $data);

		$this->seeInDatabase('components', array_merge(['id' => $component->id,], $componentData));
		$this->seeInDatabase('componentable_texts', array_merge(['id' => $component->componentable->id,], $textData['componentable']));
	}
}
