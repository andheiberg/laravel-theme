<?php

namespace Andheiberg\Theme;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Config\Repository as Config;
use Illuminate\View\Factory as View;
use Illuminate\Translation\Translator as Lang;
use Symfony\Component\HttpFoundation\Request;

class Module implements Arrayable {

	/**
	 * The modules's attributes.
	 *
	 * @var array
	 */
	public $attributes;

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
	 * @var Illuminate\View\Factory $view
	 */
	protected $renderer;

	/**
	 * Illuminate's Translator Repository.
	 *
	 * @var \Illuminate\Translation\Translator
	 */
	protected $lang;

	/**
	 * Create a new module instance.
	 *
	 * @param  Illuminate\Config\Repository  $config
	 * @param  Symfony\Component\HttpFoundation\Request  $request
	 * @param  Illuminate\View\Factory  $view
	 * @param  \Illuminate\Translation\Translator $lang
	 * @return void
	 */
	public function __construct(Config $config, Request $request, View $view, Lang $lang)
	{
		$this->config   = $config;
		$this->request  = $request;
		$this->renderer = $view;
		$this->lang     = $lang;
	}

	/**
	 * Save a new model and return the instance.
	 *
	 * @param  array  $attributes
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function create(array $attributes = array())
	{
		$this->attributes = [
			'view' => '',
			'id' => '',
			'class' => '',
			'url' => '',
			'value' => '',
			'text' => '',
			'placeholder' => '',
			'helpText' => '',
			'disabled' => false,
			'required' => false,
			'cols' => 30,
			'rows' => 10
		];

		foreach ($attributes as $key => $value)
		{
			$this->attributes[$key] = $value;
		}

		// Get old value if none is set
		if ($this->value == null and $this->id)
		{
			$this->value = $this->request->old($this->id) ?: $this->request->input($this->id);
		}

		// Create text if none is set
		if (! $this->text and $this->id)
		{
			$this->text = $this->idToText($this->id);
		}

		// Get the translation if one exists
		if ($this->lang->has($this->text))
		{
			$this->text = $this->lang->get($this->text);
		}

		return $this;
	}

	/**
	 * Render the modules view.
	 *
	 * @param  string  $part
	 * @return string
	 */
	public function render($part = null)
	{
		$view = 'theme::' . $this->config->get('theme.theme') . '.' . $this->view;

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
			if (is_bool($this->attributes[$method]) and empty($parameters))
			{
				$this->attributes[$method] = true;
			}
			elseif (is_string($parameters[0]))
			{
				$this->attributes[$method] .= ' '.$parameters[0];
			}
			elseif (is_numeric($parameters[0]))
			{
				$this->attributes[$method] = $parameters[0];
			}
			elseif (is_array($parameters[0]))
			{
				$this->attributes[$method] .= implode(' ', $parameters[0]);
			}
		}

		return $this;
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
		try
		{
			return $this->render($this->part);
		}
		catch (\Exception $e)
		{
			return (string) $e;
		}
	}

}