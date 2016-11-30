<?php

namespace App\Providers;

use App\App;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;



class AppServiceProvider extends ServiceProvider
{

	public function boot()
	{
		Relation::morphMap(App::componentablesMorphMap());
	}



	public function register()
	{
		App::updateComponentWith(config('feesy.components.updaters'));
		App::useDimensions(config('feesy.components.dimensions'));

		$this->registerImageableExtensions();
	}



	protected function registerImageableExtensions()
	{
		App::$imageableExtensions = [
			IMAGETYPE_JPEG => 'jpeg',
			IMAGETYPE_PNG  => 'png',
			IMAGETYPE_GIF  => 'gif',
			IMAGETYPE_BMP  => 'bmp',
			IMAGETYPE_PSD  => 'psd',
		];
	}
}
