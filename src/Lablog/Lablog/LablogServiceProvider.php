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

		$this->registerPost();
		$this->registerPostConfig();

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
	 * Register the required post object.
	 * @return void
	 */
	private function registerPost()
	{
		$mode = \Config::get('lablog::mode');

		$postGateway = 'Lablog\Lablog\Post\\'.ucfirst($mode).'Post';

		\App::bind('Lablog\Lablog\Post\PostGatewayInterface', $postGateway);
	}

	/**
	 * Register the required post config object.
	 * @return void
	 */
	private function registerPostConfig()
	{
		$mode = \Config::get('lablog::post.configMode') ?: 'json';

		$postConfigGateway = 'Lablog\Lablog\Post\\'.ucfirst($mode).'PostConfig';

		\App::bind('Lablog\Lablog\Post\PostConfigGatewayInterface', $postConfigGateway);
	}

}