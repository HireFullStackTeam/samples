<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Interactions\Components\UpdateComponents;
use App\Http\Requests\Api\Components\UpdateComponentsRequest;
use App\Models\Component;
use App\Transformers\ComponentTransformer;
use Dingo\Api\Http\Response;
use Illuminate\Support\Arr;



class ComponentsController extends ApiController
{

	/**
	 * @param UpdateComponentsRequest $request
	 * @return Response
	 */
	public function update(UpdateComponentsRequest $request)
	{
		// dd($request->all());

		$components = $this->interaction(UpdateComponents::class, [
			$this->prepareDataForUpdate($request->get('components'))
		]);

		return $this->response->collection($components, new ComponentTransformer);
	}



	/**
	 * @param array $components
	 * @return array
	 */
	protected function prepareDataForUpdate(array $components)
	{
		return array_map(function ($component) {
			return [
				'model'  => Component::find($component['id']),
				'values' => Arr::except($component, ['id', 'type'])
			];
		}, $components);
	}
}
