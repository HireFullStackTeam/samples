<?php

namespace App\Contracts\Interactions\Components;


use App\Models\Component;


interface DeleteComponent {

	/**
	 * @param Component $component
	 * @return bool
	 */
	public function handle(Component $component);
}
