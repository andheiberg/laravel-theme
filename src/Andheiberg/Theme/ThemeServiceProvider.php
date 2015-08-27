<?php namespace Andheiberg\Theme;

use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider {

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
		$this->loadViewsFrom(__DIR__.'/../../views', 'theme'); // theme::bootstrap.nav

		$this->publishes([
			__DIR__.'/../../views' => base_path('resources/views/vendor/theme'),
			__DIR__.'/../../config/theme.php' => config_path('theme.php'),
		]);

		$this->mergeConfigFrom(
			__DIR__.'/../../config/theme.php', 'theme'
		);
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('theme.module', function($app) {
			return new Module($app['config'], $app['request'], $app['view'], $app['translator']);
		});
		
		// Register 'theme' instance container to our Asset object
		$this->app['theme'] = $this->app->share(function($app)
		{
			return new Theme($app['theme.module']);
		});

		// Shortcut so developers don't need to add an Alias in app/config/app.php
		$this->app->booting(function()
		{
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();
			$loader->alias('Theme', 'Andheiberg\Theme\Facades\Theme');
		});

		$this->registerBladeExtensions();
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('theme');
	}

	/**
	 * Register the Blade extensions with the compiler.
	 * 
	 * @return void
	 */
	protected function registerBladeExtensions()
	{
		$blade = $this->app['view']->getEngineResolver()->resolve('blade')->getCompiler();

		$blade->extend(function($view, $compiler)
		{
			$matcher = '/(?(R)\((?:[^\(\)]|(?R))*\)|(?<!\w)(\s*)\+@([^(]*)(\s*(?R)+(?:-.*\))?))/';
			
			return preg_replace($matcher, '<?php echo $1Theme::$2Start$3; ?>', $view);
		});

		$blade->extend(function($view, $compiler)
		{
			$matcher = '/\-@(.*)(?=\r\n)?/';
			
			return preg_replace($matcher, '<?php echo Theme::$1End(); ?>', $view);
		});
	}

}