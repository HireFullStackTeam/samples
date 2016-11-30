<?php

namespace App\Http\Requests\Api\Components;



class UpdateComponentRequest extends UpdateRequest
{

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		$rules = $this->componentRules($this->all());

		if ($this->get('componentable') !== null) {
			$rules = array_merge($rules, $this->componentableRules(
				$this->component, $this->get('componentable')
			));
		};

		return $rules;
	}
}
