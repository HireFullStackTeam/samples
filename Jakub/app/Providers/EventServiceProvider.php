<?php

namespace App\Providers;

use App\Events\ComponentDeleted;
use App\Events\ProjectCreated;
use App\Listeners\ChecksProjectComponentsOrder;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;



class EventServiceProvider extends ServiceProvider
{

	/**
	 * The event listener mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		ProjectCreated::class   => [

		],
		ComponentDeleted::class => [
			ChecksProjectComponentsOrder::class,
		],
	];

}
