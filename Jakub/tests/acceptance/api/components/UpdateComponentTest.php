<?php

namespace Tests\Acceptance\Api\Components;

use App\Models\Component;
use Tests\TestCase;



class UpdateComponentTest extends TestCase
{

	/** @test */
	public function it_updates_a_size()
	{
		$component = factory(Component::class, 'text')->create([
			'height' => 1,
			'width'  => 2,
		]);

		$height = random_int(100, 50000);
		$width = random_int(100, 50000);

		$this->patch('/component/' . $component->id, [
			'height' => $height,
			'width'  => $width,
		]);

		$this->seeInDatabase('components', [
			'id'     => $component->id,
			'height' => $height,
			'width'  => $width,
		]);
	}



	/** @test */
	public function it_updates_a_position()
	{
		$component = factory(Component::class, 'text')->create([
			'position_x' => 1,
			'position_y' => 2,
		]);

		$position_x = random_int(1000, 50000);
		$position_y = random_int(1000, 50000);

		$this->patch('/component/' . $component->id, [
			'position_x' => $position_x,
			'position_y' => $position_y,
		]);

		$this->seeInDatabase('components', [
			'id'         => $component->id,
			'position_x' => $position_x,
			'position_y' => $position_y,
		]);
	}



	/** @test */
	public function it_updates_a_visibility()
	{
		$component = factory(Component::class, 'text')->create([
			'visibility' => false,
		]);

		$text = 'true';

		$this->patch('/component/' . $component->id, [
			'visibility' => $text,
		]);

		$this->seeInDatabase('components', [
			'id'         => $component->id,
			'visibility' => true,
		]);

	}



	/** @test */
	public function only_update_height_will_fail_because_update_with_singe_value_is_not_allowed()
	{
		$component = factory(Component::class, 'text')->create([
			'height' => 1,
		]);

		$this->patch('/component/' . $component->id, [
			'height' => 2,
		]);

		$this->seeInDatabase('components', [
			'id'     => $component->id,
			'height' => 1,
		]);
	}



	/** @test */
	public function only_update_position_x_will_fail_because_update_with_single_value_is_not_allowed()
	{
		$component = factory(Component::class, 'text')->create([
			'position_x' => 1,
		]);

		$this->patch('/component/' . $component->id, [
			'position_x' => 2,
		]);

		$this->seeInDatabase('components', [
			'id'         => $component->id,
			'position_x' => 1,
		]);
	}

}
