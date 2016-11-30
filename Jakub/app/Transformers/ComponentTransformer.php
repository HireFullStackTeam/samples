<?php

namespace App\Transformers;

use App\App;
use App\Models\Component;
use App\Models\Componentables\Image;
use App\Models\Componentables\Shape;
use App\Models\Componentables\Text;
use App\Transformers\Componentables\ImageTransformer;
use App\Transformers\Componentables\ShapeTransformer;
use App\Transformers\Componentables\TextTransformer;
use League\Fractal\TransformerAbstract;



class ComponentTransformer extends TransformerAbstract
{

	/**
	 * @var string[]
	 */
	protected $transformers = [
		Text::class  => TextTransformer::class,
		Shape::class => ShapeTransformer::class,
		Image::class => ImageTransformer::class,
	];



	/**
	 * @param Component $component
	 * @return array
	 */
	public function transform(Component $component)
	{
		// TODO component visibility is null, why?

		return [
			'id'                 => (int) $component->id,
			'name'               => (string) $component->name,
			'visibility'         => (bool) $component->visibility,
			'position_x'         => (int) $component->position_x,
			'position_y'         => (int) $component->position_y,
			'height'             => (int) $component->height,
			'width'              => (int) $component->width,
			'order'              => (int) $component->order,
			'componentable_type' => $component->componentable_type,
			'componentable'      => $this->componentable($component)
		];
	}



	/**
	 * @param Component $component
	 * @return array
	 */
	protected function componentable(Component $component)
	{
		$transformer = $this->componentableTransformer($component);

		return $transformer->transform($component->componentable);
	}



	/**
	 * @param Component $component
	 * @return TransformerAbstract
	 */
	protected function componentableTransformer(Component $component)
	{
		$transformer = App::componentableClassBy($component->componentable_type);

		return app($this->transformers[$transformer]);
	}

}
