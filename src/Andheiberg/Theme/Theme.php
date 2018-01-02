<?php

namespace Andheiberg\Theme;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Input;

class Theme {

	/**
	 * The module implementation.
	 *
	 * @var Andheiberg\Theme\Module
	 */
	protected $module;

	/**
	 * Create a new theme instance.
	 *
	 * @param  Andheiberg\Theme\Module  $module
	 * @return void
	 */
	public function __construct(Module $module)
	{
		$this->module  = $module;
	}

	/**
	 * Dynamically create an element
	 *
	 * @param string $method     The element
	 * @param array  $parameters Value and attributes
	 *
	 * @return Element
	 */
	public function __call($method, $parameters = array())
	{
		$closing = str_contains($method, 'End');
		$function = $closing ? str_before($method, 'End') : str_before($method, 'Start');

		if ( method_exists(get_class(), $function) )
		{
			// Get the formatted arguments from the view function
			$arguments = call_user_func_array(get_class() . '::' . $function, $parameters);
			// Get the optional options array
			$options = isset($parameters[count($arguments)]) ? $parameters[count($arguments)] : array();
			// Merge the expected arguments with the options
			$arguments = array_merge($options, $arguments);
			$module = $this->module->create($arguments);
		}
		elseif ( ! count($parameters) )
		{
			$module = $this->module->create([]);
		}
		else
		{
			$module = $this->module->create($parameters[0]);
		}

		$module->view = $this->findView($function);

		if ( $closing )
		{
			$module->part = 'end';
		}
		else
		{
			$module->part = 'start';
		}

		return $module;
	}

	public function findView($function)
	{
		$view = snake_case($function, '-');

		if ($view == 'form')
		{
			$view = 'forms.form';
		}
		elseif (starts_with($view, 'form'))
		{
			$view = 'forms.' . str_after($view, 'form-');
		}

		return $view;
	}

	public function button($text = '', $url = null, $class = '')
	{
		return compact('text', 'url', 'class');
	}

	public function deleteButton($text = '', $url = null, $class = '')
	{
		return compact('text', 'url', 'class');
	}

	public function dropdown($text = '')
	{
		return compact('text');
	}

	public function dropdownItem($text = '', $url = '#')
	{
		$url = str_contains($url, '/') ? $url : \URL::route($url);
		
		return compact('text', 'url');
	}

	public function navItem($text = '', $url = '#', $pattern = null)
	{
		$url = str_contains($url, '/') ? $url : \URL::route($url);
		$pattern = $pattern ?: substr($url, 1) . '*';
		$class = Request::is($pattern) ? 'active' : '';

		return compact('text', 'url', 'pattern', 'class');
	}


	// Forms
	// ========================================

	public function form($options = array())
	{
		return compact('options');
	}

	public function formHorizontal($options = array())
	{
		return compact('options');
	}

	public function formInline($options = array())
	{
		return compact('options');
	}

	public function formActions($class = '')
	{
		return compact('class');
	}

	public function formText($id = '', $text = null, $value = '')
	{
		return compact('id', 'text', 'value');
	}

	public function formUrl($id = '', $text = null, $value = '')
	{
		return compact('id', 'text', 'value');
	}

	public function formTextarea($id = '', $text = null, $value = '')
	{
		return compact('id', 'text', 'value');
	}

	public function formPassword($id = '', $text = null, $value = '')
	{
		return compact('id', 'text', 'value');
	}

	public function formDate($id = '', $text = null, $value = '')
	{
		return compact('id', 'text', 'value');
	}

	public function formEmail($id = '', $text = null, $value = '')
	{
		return compact('id', 'text', 'value');
	}

	public function formNumber($id = '', $text = null, $value = '')
	{
		return compact('id', 'text', 'value');
	}

	public function formHidden($id = '', $value = null)
	{
		return compact('id', 'value');
	}

	public function formSelect($id = '', $text = null, $data = [], $value = '')
	{
		return compact('id', 'text', 'data', 'value');
	}

	public function formMultiSelect($id = '', $text = null, $data = [], $value = '')
	{
		return compact('id', 'text', 'data', 'value');
	}

	public function formCheckbox($id = '', $text = null, $data = [], $value = '')
	{
		return compact('id', 'text', 'data', 'value');
	}

	public function formRadio($id = '', $text = null, $data = [], $value = '')
	{
		return compact('id', 'text', 'data', 'value');
	}

	public function formRange($text = null, $min = null, $max = null, $value = '')
	{
		return compact('id', 'text', 'min', 'max', 'value');
	}

	public function formFile($id = '', $text = null, $value = '')
	{
		return compact('id', 'text', 'value');
	}

	public function formBoolean($id = '', $text = null)
	{
		return compact('id', 'text');
	}

	public function formSubmit($text = 'Submit', $class = '')
	{
		return compact('text', 'class');
	}

}
