<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Symfony\Component\Finder\Finder;



class RouteServiceProvider extends ServiceProvider
{

	/**
	 * This namespace is applied to your controller routes.
	 *
	 * In addition, it is set as the URL generator's root namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'App\Http\Controllers';



	/**
	 * Define the routes for the application.
	 *
	 * @param  \Illuminate\Routing\Router $router
	 * @return void
	 */
	public function map(Router $router)
	{
		$this->mapWebRoutes($router);
		$this->mapApiRoutes();
	}



	/**
	 * Require web routes
	 *
	 * @param  \Illuminate\Routing\Router $router
	 * @return void
	 */
	protected function mapWebRoutes(Router $router)
	{
		$router->group([
			'namespace'  => $this->namespace,
			'middleware' => 'web',
		], function ($router) {
			foreach (Finder::create()->files()->in(base_path('routes/web')) as $file) {
				require $file->getPathname();
			}
		});

	}



	/**
	 * Require Dingo api routes
	 *
	 * @return void
	 */
	protected function mapApiRoutes()
	{
		$api = app('Dingo\Api\Routing\Router');

		$api->version('v1', function ($api) {
			$api->group([
				'namespace'  => $this->namespace,
				'middleware' => 'api',
			], function ($api) {
				foreach (Finder::create()->files()->in(base_path('routes/api')) as $file) {
					require $file->getPathname();
				}
			});
		});
	}
}
