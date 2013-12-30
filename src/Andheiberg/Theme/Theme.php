<?php namespace Andheiberg\Theme;

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
			$module = call_user_func_array(get_class() . '::' . $function, $parameters);
		}
		elseif ( ! count($parameters) )
		{
			$module = $this->module;
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

	public function button($text = '', $url = '#', $class = '')
	{
		$url = str_contains($url, '/') ? $url : \URL::route($url);

		return $this->module->create(compact('text', 'url', 'class'));
	}

	public function dropdown($text = '')
	{
		return $this->module->create(compact('text'));
	}

	public function dropdownItem($text = '', $url = '#')
	{
		$url = str_contains($url, '/') ? $url : \URL::route($url);
		
		return $this->module->create(compact('text', 'url'));
	}

	public function navItem($text = '', $url = '#', $pattern = null)
	{
		$url = str_contains($url, '/') ? $url : \URL::route($url);
		$pattern = $pattern ?: substr($url, 1) . '*';
		$class = Request::is($pattern) ? 'active' : '';

		$this->module->create(compact('text', 'url', 'pattern', 'class'));
	}


	// Forms
	// ========================================

	public function form($options = array())
	{
		return $this->module->create(compact('options'));
	}

	public function formHorizontal($options = array())
	{
		return $this->module->create(compact('options'));
	}

	public function formActions($class = '')
	{
		return $this->module->create(compact('class'));
	}

	public function formText($id = '', $text = null, $required = false, $helpText = null)
	{
		return $this->module->create(compact('id', 'text', 'required', 'helpText'));
	}

	public function formTextarea($id = '', $text = null, $required = false, $helpText = null)
	{
		return $this->module->create(compact('id', 'text', 'required', 'helpText'));
	}

	public function formPassword($id = '', $text = null, $required = false, $helpText = null)
	{
		return $this->module->create(compact('id', 'text', 'required', 'helpText'));
	}

	public function formDate($id = '', $text = null, $required = false, $helpText = null)
	{
		return $this->module->create(compact('id', 'text', 'required', 'helpText'));
	}

	public function formHidden($id = '', $value = null)
	{
		return $this->module->create(compact('id', 'value'));
	}

	public function formSelect($id = '', $text = null, $data = [], $required = false, $helpText = null)
	{		
		return $this->module->create(compact('id', 'text', 'data', 'required', 'helpText'));
	}

	public function formCheckbox($id = '', $text = null, $data = [], $required = false, $helpText = null)
	{
		return $this->module->create(compact('id', 'text', 'data', 'required', 'helpText'));
	}

	public function formRadio($id = '', $text = null, $data = [], $required = false, $helpText = null)
	{
		return $this->module->create(compact('view', 'id', 'text', 'data', 'required', 'helpText'));
	}

	public function formRange($text = null, $min = null, $max = null, $required = false, $helpText = null)
	{
		return $this->module->create(compact('id', 'text', 'min', 'max', 'required', 'helpText'));
	}

	public function formFile($id = '', $text = null, $required = false, $helpText = null)
	{
		return $this->module->create(compact('id', 'text', 'required', 'helpText'));
	}

	public function formSubmit($text = 'Submit', $class = '')
	{
		return $this->module->create(compact('text', 'class'));
	}

}