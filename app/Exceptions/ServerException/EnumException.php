<?php

namespace App\Exceptions\ServerException;

use App\Exceptions\ServerException;

class EnumException extends ServerException
{
	/**
	 * @param mixed $message
	 * @param int 	$code
	 */
	public function __construct($message, $code = 500)
	{
		parent::__construct($message, $code);
	}

	public static function badInput($input)
	{
		try {
			$input = (string) $input;
		} catch (\Exception $e) {
			$input = 'Cant convert input to string';
		}

		return new static("Your input ($input) is not a valid enum.");
	}

	public static function cantFindByValue()
	{
		return new static('This enum could not be found by its value');
	}

	public static function cantFindByKey()
	{
		return new static('This enum could not be found by its key');
	}
}
