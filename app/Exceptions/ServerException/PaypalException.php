<?php

namespace App\Exceptions\ServerException;

use App\Exceptions\ServerException;

class PaypalException extends ServerException
{
	/**
	 * @param mixed $message
	 * @param int 	$code
	 */
	public function __construct($message, $code = 500)
	{
		parent::__construct($message, $code);
	}

	public static function notOk($code)
	{
		return new static(sprintf('Paypal responded with the status code (%s), we expected a status code between 200 and 300.'), $code);
	}
}
