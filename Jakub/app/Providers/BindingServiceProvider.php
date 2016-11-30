<?php

namespace App\Providers;

use App\Feesy\Components\Updates\UpdateManager;
use App\Interactions\Components\CreateComponent;
use App\Interactions\Components\DeleteComponent;
use App\Interactions\Components\UpdateComponent;
use App\Interactions\Components\UpdateComponents;
use App\Interactions\Feed\UploadProductDataFeed;
use App\Interactions\Fonts\CreateFont;
use App\Interactions\Fonts\DeleteFont;
use App\Interactions\Gallery\UploadImageableFile;
use App\Interactions\Projects\CreateProject;
use App\Interactions\Projects\DeleteProject;
use App\Interactions\Projects\UpdateProject;
use App\Interactions\Shapes\CreateShape;
use App\Repositories\ComponentRepository;
use App\Repositories\FontRepository;
use App\Repositories\Gallery\ImageRepository;
use App\Repositories\Products\DatabaseProductRepository;
use App\Repositories\ProjectRepository;
use Illuminate\Support\ServiceProvider;



class BindingServiceProvider extends ServiceProvider
{

	/**
	 * @return void
	 */
	public function register()
	{
		$bindings = [
			// Interactions ...
			\App\Contracts\Interactions\Components\DeleteComponent::class  => DeleteComponent::class,
			\App\Contracts\Interactions\Components\CreateComponent::class  => CreateComponent::class,
			\App\Contracts\Interactions\Components\UpdateComponent::class  => UpdateComponent::class,
			\App\Contracts\Interactions\Components\UpdateComponents::class => UpdateComponents::class,
			\App\Contracts\Interactions\Projects\CreateProject::class      => CreateProject::class,
			\App\Contracts\Interactions\Projects\UpdateProject::class      => UpdateProject::class,
			\App\Contracts\Interactions\Projects\DeleteProject::class      => DeleteProject::class,
			\App\Contracts\Interactions\Fonts\CreateFont::class            => CreateFont::class,
			\App\Contracts\Interactions\Fonts\DeleteFont::class            => DeleteFont::class,
			\App\Contracts\Interactions\Gallery\UploadImageableFile::class => UploadImageableFile::class,
			\App\Contracts\Interactions\Shapes\CreateShape::class          => CreateShape::class,
			\App\Contracts\Interactions\Feed\UploadProductDataFeed::class  => UploadProductDataFeed::class,

			// Repositories ...
			\App\Contracts\Repositories\ProjectRepository::class           => ProjectRepository::class,
			\App\Contracts\Repositories\ComponentRepository::class         => ComponentRepository::class,
			\App\Contracts\Repositories\FontRepository::class              => FontRepository::class,
			\App\Contracts\Repositories\Gallery\ImageRepository::class     => ImageRepository::class,
			\App\Contracts\Repositories\ProductRepository::class           => DatabaseProductRepository::class,

			// Others ...
			\App\Contracts\Feesy\Components\UpdateManager::class           => UpdateManager::class,
		];

		foreach ($bindings as $contract => $implementation) {
			$this->app->singleton($contract, $implementation);
		}
	}
}
