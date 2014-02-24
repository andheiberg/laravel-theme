<?php

if ( ! function_exists('str_after'))
{
	/**
	 * Get the rest of a string after needle.
	 *
	 * @param  string  $haystack
	 * @param  string  $needle
	 * @return string
	 */
	function str_after($haystack, $needle) 
	{
		$string = strstr($haystack, $needle);
		$string = str_replace($needle, '', $string);

		return $string == '' ? false : $string;
	}
}

if ( ! function_exists('str_before'))
{
	/**
	 * Get the part of a string before needle.
	 *
	 * @param  string  $haystack
	 * @param  string  $needle
	 * @return string
	 */
	function str_before($haystack, $needle) 
	{
		$needlePosition = strpos($haystack, $needle);
		$string = substr($haystack, 0, $needlePosition);

		return $string == '' ? false : $string;
	}
}

if ( ! function_exists('is_associative'))
{
	/**
	 * Checks if an array is associative
	 *
	 * @param  array  $array
	 * @return bool
	 */
	function is_associative($array)
	{
		return array_keys($array) !== range(0, count($array) - 1);
	}
}

if ( ! function_exists('theme_compare_values'))
{
	/**
	 * Checks if an array is associative
	 *
	 * @param  array  $array
	 * @return bool
	 */
	function theme_compare_values($one, $two)
	{
		if (is_numeric($one))
		{
			return (int) $one == (int) $two;
		}

		return $one == $two;
	}
}