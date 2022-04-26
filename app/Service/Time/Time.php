<?php

namespace App\Service\Time;

use Carbon\Carbon;

class Time
{
	public static function now()
	{
		//TODO : ensure the time is always the same, otherwise jwt verification might fail.
		
		return time();
	}

	public static function unixToDate($time = null)
	{
		$time = $time ?: static::now();

		return Carbon::createFromTimestamp($time);
	}

	public static function unixToReadable($time)
	{
		$carbon = Carbon::createFromTimestamp($time);

		return $carbon->diffForHumans();
	}

	/**
	 * Check if the $check_time was recent
	 *
	 * @return boolean true|false
	 */
	public static function isRecent($check_time, $reference_time = null, $recent_time = null)
	{
		$check_time     = static::fromCarbon($check_time);
		$reference_time = $reference_time ? static::fromCarbon($reference_time) : static::now();
		$recent_time    = $recent_time ? static::fromCarbon($reference_time) : 60 * 15;

		$remaining = $reference_time - $check_time;

		return $remaining < $recent_time;
	}

	/**
	 * Return the timestamp of the carbon instance, else return $input
	 *
	 * @return unix timestamp.
	 */
	private static function fromCarbon($input)
	{
		if ($input instanceof Carbon)
		{
			return $input->timestamp;
		}

		return $input;
	}
}
