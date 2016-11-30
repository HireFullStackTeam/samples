<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as Contract;



abstract class TestCase extends Contract
{

	use DatabaseTransactions;

	/**
	 * The base URL to use while testing the application.
	 *
	 * @var string
	 */
	protected $baseUrl;



	/**
	 * Creates the application.
	 *
	 * @return \Illuminate\Foundation\Application
	 */
	public function createApplication()
	{
		$app = require __DIR__ . '/../bootstrap/app.php';

		$app->make(Kernel::class)->bootstrap();

		$this->baseUrl = self::apiBaseUrl($app['config']);

		return $app;
	}



	/**
	 * @param array $config
	 * @return string
	 */
	protected static function apiBaseUrl($config)
	{
		return $config['app']['url'] . '/' . $config['api']['prefix'];
	}
}
