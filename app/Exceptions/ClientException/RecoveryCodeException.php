<?php

namespace App\Exceptions\ClientException;

use App\Exceptions\ClientException;

class RecoveryCodeException extends ClientException
{
	public function __construct($message, $code = 400) //TODO : find better http status code.
	{
		parent::__construct($message, $code);
	}

    public static function invalid()
    {
        return new static('This token is invalid.');
    }
}
