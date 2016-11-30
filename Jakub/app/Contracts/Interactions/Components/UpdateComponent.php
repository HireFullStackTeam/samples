<?php

namespace App\Contracts\Interactions\Components;


use App\Models\Component;



interface UpdateComponent
{

	/**
	 * @param Component $component
	 * @param array $data
	 * @return Component
	 */
	public function handle(Component $component, array $data);
}
