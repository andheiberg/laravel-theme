<?php namespace Andheiberg\Theme;

use Illuminate\Support\Contracts\ArrayableInterface;
use Illuminate\Config\Repository as Config;
use Illuminate\View\Environment as View;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\App;

class Module implements ArrayableInterface {

	/**
	 * The modules's attributes.
	 *
	 * @var array
	 */
	public $attributes = array(
		'view' => '',
		'id' => '',
		'class' => '',
		'url' => '',
		'value' => '',
		'text' => '',
		'disabled' => false,
	);

	/**
	 * The model's attributes.
	 *
	 * @var array
	 */
	protected $render;

	/**
	 * The model's attributes.
	 *
	 * @var array
	 */
	protected $delimiter = '<!-- Content -->';

	/**
	 * The model's attributes.
	 *
	 * @var array
	 */
	protected $part;

	/**
	 * The config implementation.
	 *
	 * @var Illuminate\Config\Repository
	 */
	protected $config;

	/**
	 * The request implementation.
	 *
	 * @var Symfony\Component\HttpFoundation\Request
	 */
	protected $request;

	/**
	 * The view implementation.
	 *
	 * @var Illuminate\View\Environment $view
	 */
	protected $renderer;

	/**
	 * Create a new module instance.
	 *
	 * @param  Illuminate\Config\Repository  $config
	 * @param  Symfony\Component\HttpFoundation\Request  $request
	 * @param  Illuminate\View\Environment  $view
	 * @return void
	 */
	public function __construct(Config $config, Request $request, View $view)
	{
		$this->config  = $config;
		$this->request = $request;
		$this->renderer    = $view;
	}

	/**
	 * Save a new model and return the instance.
	 *
	 * @param  array  $attributes
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public static function create(array $attributes)
	{
		$instance = App::make('Andheiberg\Theme\Module');

		foreach ($attributes as $key => $value)
		{
			$instance->attributes[$key] = $value;
		}

		if ($instance->id && $instance->value == null)
		{
			$instance->value = $instance->request->old($instance->id) ?: $instance->request->input($instance->id);
		}

		if ($instance->id && ! $instance->text)
		{
			$instance->text = $instance->idToText($instance->id);
		}

		return $instance;
	}

	/**
	 * Render the modules view.
	 *
	 * @param  string  $part
	 * @return string
	 */
	public function render($part = null)
	{
		$view = 'themes.' . $this->config->get('theme::theme') . '.' . $this->view;

		if ( ! file_exists( app_path() . '/views/' . str_replace('.', '/', $view) . '.blade.php' ) )
		{
			$view = 'theme::' . $view;
		}

		$render = $this->renderer->make($view, $this->attributes)->render();

		switch ($part)
		{
			case 'start':
				return str_before($render, $this->delimiter) ?: $render;

			case 'end':
				return str_after($render, $this->delimiter) ?: $render;

			default:
				return $render;
		}
	}

	/**
	 * Convert a element id to human readable text.
	 *
	 * @param  string  $part
	 * @return string
	 */
	public function idToText($id)
	{
		return ucfirst(str_replace('_', ' ', $id));
	}

	/**
	 * Handle dynamic method calls into the method.
	 *
	 * @param  string  $method
	 * @param  array   $parameters
	 * @return mixed
	 */
	public function __call($method, $parameters)
	{
		if (array_key_exists($method, $this->attributes))
		{
			if (is_bool($this->attributes[$method]))
			{
				$this->attributes[$method] = true;
			}
			elseif (is_string($this->attributes[$method]))
			{
				$this->attributes[$method] .= ' '.$parameters[0];
			}
			elseif (is_array($this->attributes[$method]))
			{
				$this->attributes[$method] .= implode(' ', $parameters[0]);
			}
		}

		return $this;
	}

	/**
	 * Handle dynamic static method calls into the method.
	 *
	 * @param  string  $method
	 * @param  array   $parameters
	 * @return mixed
	 */
	public static function __callStatic($method, $parameters)
	{
		$instance = App::make('Andheiberg\Theme\Module');

		return call_user_func_array(array($instance, $method), $parameters);
	}

	/**
	 * Dynamically set attributes on the model.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public function __set($key, $value)
	{
		if (in_array($key, ['render', 'delimiter', 'part']))
		{
			$this->$key = $value;
		}
		else
		{
			$this->attributes[$key] = $value;
		}

		$this->render = null;
	}

	/**
	 * Dynamically retrieve attributes on the model.
	 *
	 * @param  string  $key
	 * @return mixed
	 */
	public function __get($key)
	{
		if (array_key_exists($key, $this->attributes))
		{
			return $this->attributes[$key];
		}
	}

	/**
	 * Determine if an attribute exists on the model.
	 *
	 * @param  string  $key
	 * @return void
	 */
	public function __isset($key)
	{
		return isset($this->attributes[$key]);
	}

	/**
	 * Convert the model instance to an array.
	 *
	 * @return array
	 */
	public function toArray()
	{
		return get_object_vars($this);
	}

	/**
	 * Convert the model to its string representation.
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->render($this->part);
	}

}