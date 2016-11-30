<?php

namespace Tests\Integration\Requests;

use App\Http\Requests\Api\Components\UpdateComponentRequest;
use App\Models\Component;
use Illuminate\Support\Arr;
use Tests\TestCase;



class UpdateComponentRequestRulesTest extends TestCase
{

	/**
	 * @var string[]
	 */
	protected $exclude = [
		'id',
		'updated_at',
		'created_at',
		'componentable_id',
		'componentable_type'
	];

	/**
	 * @var array
	 */
	protected $componentable = [
		'componentable' => [
			'content' => 'custom content',
			'state'   => 'custom state'
		]
	];

	/**
	 * @var bool
	 */
	protected $withComponentable = true;



	/** @test */
	public function it_updates_a_component_with_all_data()
	{
		$request = $this->prepareRequest(
			$component = factory(Component::class, 'text')->create()
		);

		$this->assertEquals([
			'name'                  => 'required',
			'visibility'            => 'required',
			'height'                => 'required',
			'width'                 => 'required',
			'position_x'            => 'required',
			'position_y'            => 'required'
		], $request->rules());
	}



	/** @test */
	public function it_updates_only_dimensions()
	{
		$this->withComponentable = false;

		$request = $this->prepareRequest(
			$component = factory(Component::class, 'text')->create(),
			['name', 'position_x', 'position_y', 'visibility']
		);

		$this->assertEquals([
			'width'  => 'required',
			'height' => 'required'
		], $request->rules());
	}



	/** @test */
	public function it_updates_only_position()
	{
		$this->withComponentable = false;

		$request = $this->prepareRequest(
			$component = factory(Component::class, 'text')->create(),
			['name', 'width', 'height', 'visibility']
		);

		$this->assertEquals([
			'position_x' => 'required',
			'position_y' => 'required'
		], $request->rules());
	}



	/**
	 * @param Component $component
	 * @param array $exclude
	 * @return UpdateComponentRequest
	 */
	protected function prepareRequest(Component $component, $exclude = [])
	{
		$request = new UpdateComponentRequest();

		$data = Arr::except($component->toArray(), array_merge($this->exclude, $exclude));

		$data['component'] = $component;

		if ($this->withComponentable === true) {
			$data = array_merge($data, $this->componentable);
		}

		$request->merge($data);

		return $request;
	}
}
