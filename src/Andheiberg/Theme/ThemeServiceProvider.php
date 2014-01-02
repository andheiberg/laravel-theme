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
		$this->package('andheiberg/theme');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('Andheiberg\Theme\Module', function($app) {
			return new Module($app['config'], $app['request'], $app['view']);
		});
		
		// Register 'theme' instance container to our Asset object
		$this->app['theme'] = $this->app->share(function($app)
		{
			return new Theme($app->make('Andheiberg\Theme\Module'));
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

		$blade->extend(function($value, $compiler)
		{
			$matcher = '/\+@([^(]*)(.*\))/';
			
			return preg_replace($matcher, '<?php echo Theme::$1Start$2; ?>', $value);
		});

		$blade->extend(function($value, $compiler)
		{
			$matcher = '/\-@(.*)/';
			
			return preg_replace($matcher, '<?php echo Theme::$1End(); ?>', $value);
		});
	}

}