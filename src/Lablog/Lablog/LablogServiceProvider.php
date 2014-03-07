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

		$this->registerProcessor();
		$this->registerPage();
		$this->registerPageConfig();
		$this->registerPost();
		$this->registerPostConfig();
		$this->registerCategory();
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

		\Config::set('twigbridge::extensions', $twig);
	}

	/**
	 * Register the processor to use on content.
	 * @return void
	 */
	private function registerProcessor()
	{
		\App::bind(
			'Lablog\Lablog\Processor\ProcessorInterface',
			'Lablog\Lablog\Processor\MarkdownProcessor'
		);
	}

	/**
	 * Register the required page type.
	 * @return void
	 */
	private function registerPage()
	{
		$mode = \Config::get('lablog::mode');

		$pageGateway = 'Lablog\Lablog\Page\\'.ucfirst($mode).'Page';

		\App::bind('Lablog\Lablog\Page\PageGatewayInterface', $pageGateway);
	}

	private function registerPageConfig()
	{
		$mode = \Config::get('lablog::page.configMode') ?: 'json';

		$pageConfigGateway = 'Lablog\Lablog\Page\\'.ucfirst($mode).'PageConfig';

		\App::bind('Lablog\Lablog\Page\PageConfigGatewayInterface', $pageConfigGateway);
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

	private function registerCategory()
	{
		$mode = \Config::get('lablog::mode');

		$postConfigGateway = 'Lablog\Lablog\Category\\'.ucfirst($mode).'Category';

		\App::bind('Lablog\Lablog\Category\CategoryGatewayInterface', $postConfigGateway);
	}

}