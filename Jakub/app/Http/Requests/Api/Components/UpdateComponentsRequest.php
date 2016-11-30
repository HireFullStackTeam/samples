<?php

namespace App\Http\Requests\Api\Components;

use App\Models\Component;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;



class UpdateComponentsRequest extends UpdateRequest
{

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		$this->validateRequiredValues();

		foreach ($this->get('components') as $component) {
			$rules = $this->componentRules($component);

			if (isset($component['componentable']) === true) {
				$rules = array_merge($rules, $this->componentableRules(
					Component::find($component['id']), $component['componentable']
				));
			}

			$this->validateComponent($component, $rules);
		}

		return [];
	}



	/**
	 * @param array $component
	 * @param array $rules
	 */
	protected function validateComponent(array $component, array $rules)
	{
		$validator = Validator::make($component, $rules);

		if ($validator->errors()->any() === true) {
			$this->failedValidation($validator);
		}
	}



	protected function validateRequiredValues()
	{
		$validator = Validator::make($this->all(), [
			'components.*.id' => [
				'required', Rule::exists('components', 'id')
			]
		]);

		if ($validator->errors()->any() === true) {
			$this->failedValidation($validator);
		}
	}
}
