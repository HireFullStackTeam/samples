<?php

namespace Tests\Integration\Requests;

use App\Http\Requests\Api\Components\UpdateComponentsRequest;
use App\Models\Component;
use Dingo\Api\Http\Request;
use Illuminate\Container\Container;
use Tests\TestCase;



class UpdateComponentsRequestRulesTest extends TestCase
{

	/**
	 * @test
	 * @expectedException \Dingo\Api\Exception\ValidationHttpException
	 */
	public function it_throws_an_exception_when_invalid_id_given()
	{
		$this->failsOn([
			'components' => [
				[
					'id' => 666
				]
			]
		]);
	}



	/** @test */
	public function it_throws_no_exception_when_valid_id_given()
	{
		$component = factory(Component::class)->create();

		$this->notFailsOn([
			'components' => [
				[
					'id' => $component->id
				]
			]
		]);
	}



	/**
	 * @test
	 * @expectedException \Dingo\Api\Exception\ValidationHttpException
	 */
	public function it_throws_an_exception_when_one_of_ids_is_invalid()
	{
		$component = factory(Component::class)->create();

		$this->failsOn([
			'components' => [
				[
					'id' => $component->id
				],
				[
					'id' => 666
				]
			]
		]);
	}



	/**
	 * @test
	 * @expectedException \Dingo\Api\Exception\ValidationHttpException
	 */
	public function it_throws_an_exception_when_only_width_of_component_given()
	{
		$component = factory(Component::class)->create();

		$this->failsOn([
			'components' => [
				[
					'id'    => $component->id,
					'width' => 666,
				]
			]
		]);
	}



	/** @test */
	public function it_does_not_throw_an_exception_when_wrong_text_componentable_data_given()
	{
		$component = factory(Component::class, 'text')->create();

		$this->notFailsOn([
			'components' => [
				[
					'id'            => $component->id,
					'componentable' => [
						'content' => '',
						'state'   => ''
					]
				]
			]
		]);
	}



	/** @test */
	public function it_does_not_throw_an_exception_when_wrong_shape_componentable_data_given()
	{
		$component = factory(Component::class, 'shape')->create();

		$this->notFailsOn([
			'components' => [
				[
					'id'            => $component->id,
					'componentable' => [
						'color' => ''
					]
				]
			]
		]);
	}



	/**
	 * @param array $data
	 */
	protected function failsOn(array $data)
	{
		$request = $this->request();

		$request->merge($data);

		$request->rules();
	}



	/**
	 * @param array $data
	 */
	protected function notFailsOn(array $data)
	{
		$request = $this->request();

		$request->merge($data);

		$this->assertEmpty($request->rules());
	}



	/**
	 * @return UpdateComponentsRequest
	 */
	protected function request()
	{
		$request = new UpdateComponentsRequest;

		$container = new Container();
		$container['request'] = new Request();

		$request->setContainer($container);

		return $request;
	}
}
