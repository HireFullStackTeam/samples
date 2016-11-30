<?php

namespace App\Interactions\Components;

use App\App;
use App\Contracts\Interactions\Components\UpdateComponents as Contract;
use App\Models\Component;
use Illuminate\Support\Facades\Validator;



class UpdateComponents implements Contract
{

	/**
	 * @var Component[]
	 */
	protected $components = [];



	/**
	 * {@inheritdoc}
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'*.model'  => 'required',
			'*.values' => 'required'
		]);
	}



	/**
	 * {@inheritdoc}
	 */
	public function handle(array $data)
	{
		foreach ($data as $component) {
			$this->addToComponents(
				App::interact(UpdateComponent::class, [
					$component['model'], $component['values']
				])
			);
		}

		return collect($this->components);
	}



	/**
	 * @param Component $component
	 */
	protected function addToComponents(Component $component)
	{
		$this->components[] = $component;
	}
}
