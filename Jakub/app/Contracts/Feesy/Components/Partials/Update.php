<?php

namespace App\Contracts\Feesy\Components\Partials;

use App\Models\Component;



interface Update
{

	/**
	 * @param Component $component
	 * @param array $data
	 */
	public function update(Component $component, array $data);
}
