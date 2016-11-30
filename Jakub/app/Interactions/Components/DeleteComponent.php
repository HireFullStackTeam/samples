<?php

namespace App\Interactions\Components;

use App\App;
use App\Contracts\Interactions\Components\DeleteComponent as Contract;
use App\Events\ComponentDeleted;
use App\Feesy\Components\Deletes\ImageDelete;
use App\Feesy\Components\Deletes\ShapeDelete;
use App\Feesy\Components\Deletes\TextDelete;
use App\Models\Component;
use App\Models\Componentables\Image;
use App\Models\Componentables\Shape;
use App\Models\Componentables\Text;



class DeleteComponent implements Contract
{

	/**
	 * @var string[]
	 */
	protected static $classes = [
		Text::class  => TextDelete::class,
		Shape::class => ShapeDelete::class,
		Image::class => ImageDelete::class,
	];



	/**
	 * @param Component $component
	 * @return bool
	 */
	public function handle(Component $component)
	{
		$this->deleteComponentable($component);

		$component->delete();

		event(new ComponentDeleted($component));

		return true;
	}



	/**
	 * @param Component $component
	 */
	protected function deleteComponentable(Component $component)
	{
		$class = $this->componentableDeleteClass($component);

		call_user_func($class . '::delete', $component->componentable);
	}



	/**
	 * @param Component $component
	 * @return string
	 */
	protected function componentableDeleteClass(Component $component)
	{
		return static::$classes[App::componentableClassBy($component->componentable_type)];
	}
}
