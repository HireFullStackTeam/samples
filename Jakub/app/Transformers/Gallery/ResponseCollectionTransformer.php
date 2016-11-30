<?php

namespace App\Transformers\Gallery;

use App\Gallery\Support\ResponseCollection;
use App\Transformers\ComponentTransformer;
use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;



class ResponseCollectionTransformer extends TransformerAbstract
{

	/**
	 * @var string[]
	 */
	protected $defaultIncludes = [
		'images',
		'components',
	];



	/**
	 * @return array
	 */
	public function transform()
	{
		return [];
	}



	/**
	 * @param ResponseCollection $response
	 * @return Collection
	 */
	public function includeImages(ResponseCollection $response)
	{
		return $this->collection($response->images(), new ImageTransformer);
	}



	/**
	 * @param ResponseCollection $response
	 * @return Collection|null
	 */
	public function includeComponents(ResponseCollection $response)
	{
		if ($response->components()->count() > 0) {
			return $this->collection($response->components(), new ComponentTransformer);
		}

		return null;
	}
}
