<?php

namespace App\Exceptions\ServerException;

use App\Exceptions\ServerException;

class SecurityException extends ServerException
{
	/**
	 * @param mixed $message
	 * @param int 	$code
	 */
	public function __construct($message, $code = 501)
	{
		parent::__construct($message, $code);
	}

	public static function badUserid($id = null)
	{
		$id = $id ?: 'null'; //ugh.

		\Log::critical("User with id : ($id) tried to create an address.");

		return new static("User with id : ($id) tried to create an address.");
	}
}
