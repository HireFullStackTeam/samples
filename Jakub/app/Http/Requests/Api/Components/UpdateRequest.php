<?php

namespace App\Http\Requests\Api\Components;

use App\App;
use App\Contracts\Feesy\Components\Partials\Update;
use App\Models\Component;
use Dingo\Api\Http\FormRequest;
use Illuminate\Support\Arr;



abstract class UpdateRequest extends FormRequest
{

	/**
	 * @var Update[]
	 */
	protected $updaters = [];



	/**
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}



	/**
	 * @return array
	 */
	abstract public function rules();



	/**
	 * @param string|null $updater
	 * @return array
	 */
	protected function getRulesFor($updater)
	{
		if ($updater === null || in_array($updater, $this->updaters) === true) {
			return [];
		}

		array_push($this->updaters, $updater);

		return call_user_func([app($updater), 'rules']);
	}



	/**
	 * @param Component $component
	 * @param array     $componentable
	 * @return array
	 */
	protected function componentableRules(Component $component, array $componentable)
	{
		$rules = [];

		foreach ($componentable as $key => $value) {
			$updater = App::componentUpdaterNameBy(implode('.', [
				'componentable', $component->componentable_type, $key,
			]));

			$rules = array_merge($rules, $this->getRulesFor($updater));
		}

		if ($rules !== []) {
			return Arr::dot(['componentable' => $rules]);
		}

		return [];
	}



	/**
	 * @param array $component
	 * @return array
	 */
	protected function componentRules(array $component)
	{
		$rules = [];

		foreach (Arr::except($component, 'componentable') as $key => $value) {
			$rules = array_merge($rules, $this->getRulesFor(
				App::componentUpdaterNameBy($key)
			));
		}

		return $rules;
	}
}
