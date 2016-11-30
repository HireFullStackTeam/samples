<?php

namespace App\Providers;

use App\Contracts\Gallery\Manager;
use App\Gallery\Factory\ImageableFactory;
use App\Gallery\Factory\PhotoshopFactory;
use App\Gallery\ImageableManager;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;



class GalleryServiceProvider extends ServiceProvider
{

	public function register()
	{
		$this->app->singleton(ImageableManager::class, function (Application $app) {
			return new ImageableManager($app);
		});

		$this->app->alias(ImageableManager::class, Manager::class);

		$this->app->bind(\App\Contracts\Gallery\Factory\ImageableFactory::class, ImageableFactory::class);
		$this->app->bind(\App\Contracts\Gallery\Factory\PhotoshopFactory::class, PhotoshopFactory::class);
	}
}
