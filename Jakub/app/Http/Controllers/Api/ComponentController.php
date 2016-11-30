<?php

namespace App\Http\Controllers\Api;

use App\App;
use App\Contracts\Interactions\Components\CreateComponent;
use App\Contracts\Interactions\Components\DeleteComponent;
use App\Contracts\Interactions\Components\UpdateComponent;
use App\Exceptions\UndefinedFactoryException;
use App\Http\Requests\Api\Components\UpdateComponentRequest;
use App\Http\Requests\Components\StoreComponentRequest;
use App\Models\Component;
use App\Transformers\ComponentTransformer;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\Response;



class ComponentController extends ApiController
{

	/**
	 * @param StoreComponentRequest $request
	 * @return Response
	 */
	public function store(StoreComponentRequest $request)
	{
		try {
			$component = App::interact(CreateComponent::class, [$request->all()]);

		} catch (UndefinedFactoryException $e) {
			throw new StoreResourceFailedException($e->getMessage());
		}

		return $this->response->item($component, new ComponentTransformer);
	}



	/**
	 * @param UpdateComponentRequest $request
	 * @param Component              $component
	 * @return Response
	 */
	public function update(UpdateComponentRequest $request, Component $component)
	{
		$component = App::interact(UpdateComponent::class, [
			$component, $request->all(),
		]);

		return $this->response->item($component, new ComponentTransformer);
	}



	/**
	 * @param Component $component
	 * @return Response
	 */
	public function destroy(Component $component)
	{
		App::interact(DeleteComponent::class, [$component]);

		return $this->response->noContent();
	}
}
