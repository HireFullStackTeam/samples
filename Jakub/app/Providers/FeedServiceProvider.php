<?php

namespace App\Providers;

use App\Contracts\Feed\Factory\ParserFactory;
use App\Contracts\Feed\Factory\ReaderFactory;
use App\Feed\Feed;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;



class FeedServiceProvider extends ServiceProvider
{

	/**
	 * @var bool
	 */
	protected $defer = true;



	public function register()
	{
		$this->app->singleton(\App\Contracts\Feed\Feed::class, Feed::class);

		$this->app->bind(ParserFactory::class, function (Application $app) {
			return new \App\Feed\Factory\ParserFactory(
				$app['config']['feed']['parsers'],
				$app['config']['feed']['mappers']
			);
		});

		$this->app->bind(ReaderFactory::class, \App\Feed\Factory\ReaderFactory::class);
	}



	/**
	 * @return string[]
	 */
	public function provides()
	{
		return [
			ParserFactory::class,
			\App\Contracts\Feed\Feed::class,
			ReaderFactory::class
		];
	}
}
