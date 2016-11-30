<?php

namespace App\Contracts\Feesy\Components;

use App\Models\Component;



interface UpdateManager
{

	/**
	 * @param string $updater
	 * @return bool
	 */
	public function exists($updater);



	/**
	 * @param Component $component
	 * @param array     $values
	 * @return void
	 */
	public function update(Component $component, array $values);
}
