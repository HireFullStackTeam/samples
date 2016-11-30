<?php

return [
	// A component's dimensions can fit into the project so we don't need to resize it.
	[
		'type'      => [1200, 1000],
		'image'     => [1000, 800],
		'component' => [1000, 800]
	],
	// Wider, resize
	[
		'type'      => [1500, 1000],
		'image'     => [2000, 1000],
		'component' => [1500, 750]
	],
	// Higher, resize
	[
		'type'      => [1000, 1500],
		'image'     => [1000, 2000],
		'component' => [750, 1500]
	],
	// Same, keep
	[
		'type'      => [1000, 1000],
		'image'     => [1000, 1000],
		'component' => [1000, 1000]
	],
	// Same, keep
	[
		'type'      => [1000, 500],
		'image'     => [1000, 500],
		'component' => [1000, 500]
	],
	// Same, keep
	[
		'type'      => [500, 1000],
		'image'     => [500, 1000],
		'component' => [500, 1000]
	],
	// Dimensions bigger, wider, resize
	[
		'type'      => [1000, 1000],
		'image'     => [1500, 1200],
		'component' => [1000, 800]
	],
	// Dimensions bigger, higher, resize
	[
		'type'      => [1000, 1000],
		'image'     => [1200, 1500],
		'component' => [800, 1000]
	],
	// Wider, resize
	[
		'type'      => [1000, 1000],
		'image'     => [1200, 800],
		'component' => [1000, 666]
	],
	// Higher, resize
	[
		'type'      => [1000, 1000],
		'image'     => [800, 1200],
		'component' => [666, 1000]
	],
];
