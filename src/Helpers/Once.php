<?php

namespace Zareismail\Contracts\Helpers;



class Once
{
	/**
	 * Array of cached values.
	 * 
	 * @var array
	 */
	protected static $values = [];

	/**
	 * Get value from cache if exists.
	 * 
	 * @param  string $key      
	 * @param  mixed $callback 
	 * @return mixed           
	 */
	public static function get(string $key, $callback)
	{
		$cacheKey = md5($key);

		if(! isset(static::$values[$cacheKey])) {
			static::$values[$cacheKey] = is_callable($callback) ? $callback() : value($callback);
		}

		return static::$values[$cacheKey];
	}
}