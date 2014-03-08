<?php

namespace Lablog\Lablog;

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

		$this->registerBindings();
		$this->registerTwigModules();

		\Config::set('twigbridge::twig.autoescape', false);

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

	/**
	 * Register twig modules.
	 * @return void
	 */
	public function registerTwigModules()
	{
		$twig = \Config::get('twigbridge::extensions');

		$twig[] = 'Lablog\Lablog\Twig\PaginationLoader';
		$twig[] = 'Lablog\Lablog\Twig\CategoryLoader';
		$twig[] = 'Lablog\Lablog\Twig\PostLoader';

		\Config::set('twigbridge::extensions', $twig);
	}

	public function registerBindings()
	{
		$bindings = \Config::get('lablog::bindings');

		foreach ($bindings as $interface => $binding) {
			\App::bind($interface, $binding);
		}
	}

}