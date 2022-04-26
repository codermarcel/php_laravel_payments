<?php

namespace App\Exceptions\ClientException;

use App\Entity\Product;
use App\Entity\user;
use App\Exceptions\ClientException;

class PaypalException extends ClientException
{
	public function __construct($message, $code = 400)
	{
		parent::__construct($message, $code);
	}

    public static function noProfile()
    {
        return new static('The Sellers has not created a paypal profile yet.');
    }

    public static function notEnabled()
    {
        return new static('The Sellers has not enabled paypal as an accepeted payment method.');
    }

    public static function notConfigured()
    {
        return new static('The Sellers paypal profile settings have not been configured correctly.');
    }
}
