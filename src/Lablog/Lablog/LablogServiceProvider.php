<?php namespace Lablog\Lablog;

use Illuminate\Support\ServiceProvider;

class LablogServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('lablog/lablog');
		$this->app['config']->package('lablog/lablog', __DIR__.'/../../config');

		$mode = \Config::get('lablog::mode');

		$postMode = 'Lablog\Lablog\Post\\'.ucfirst($mode).'Post';

		$this->app['lablog'] = function() use ($postMode) {
			return (object) array(
				'post' => new $postMode,
			);
		};

		include __DIR__.'/../../routes.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{

	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}