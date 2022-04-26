<?php

namespace App\Entity\Decorator;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseDecorator
{
	/**
	 * Decorate a Eloquent collection.
	 */
	public static function decorateCollection(Collection $collection)
	{
		return $collection->transform(function ($item, $key) {
		    return static::decorate($item);
		});
	}

	/**
	 * Set a value if it is not null.
	 *
	 * @param $key
	 * @param $value
	 * @param bool $forceNull
	 */
	public function set($key, $value, $forceNull = false)
	{
		if ($forceNull || ! empty($value))
		{
			$this->$key = $value;
		}
	}

	/**
	 * Decorate a single Model.
	 */
	abstract public static function decorate(Model $model);
}
