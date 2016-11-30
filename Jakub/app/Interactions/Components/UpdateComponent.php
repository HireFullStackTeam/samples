<?php

namespace App\Interactions\Components;

use App\Contracts\Feesy\Components\UpdateManager;
use App\Contracts\Interactions\Components\UpdateComponent as Contract;
use App\Models\Component;



class UpdateComponent implements Contract
{

	/**
	 * @var UpdateManager
	 */
	protected $updater;



	/**
	 * @param UpdateManager $updater
	 */
	public function __construct(UpdateManager $updater)
	{
		$this->updater = $updater;
	}



	/**
	 * {@inheritdoc}
	 */
	public function handle(Component $component, array $data)
	{
		$this->updater->update($component, $data);

		return $component->fresh();
	}

}
