<?php

namespace App\Exceptions\ClientException;

use App\Exceptions\ClientException;

class PaymentException extends ClientException
{
	public function __construct($message, $code = 400)
	{
		parent::__construct($message, $code);
	}
    
    public static function outsideMargin()
    {
        return new static('The payed amount does not match the amount required.');
    }

    public static function cantMove()
    {
        return new static('Could not move payment to invoice.'); //TODO : improve this msg.
    }

    public static function invalidService()
    {
        return new static('The service is incorrect.'); //TODO : improve this msg.
    }
}
