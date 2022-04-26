<?php

namespace App\Exceptions\ClientException;

use App\Exceptions\ClientException;

class CoinbaseException extends ClientException
{
	public function __construct($message, $code = 400)
	{
		parent::__construct($message, $code);
	}

    public static function noProfile()
    {
        return new static('The Sellers has not created a coinbase profile yet.');
    }

    public static function notEnabled()
    {
        return new static('The Sellers has not enabled coinbase as an accepeted payment method.');
    }

    public static function notConfigured()
    {
        return new static('The Sellers coinbase profile settings have not been configured correctly.');
    }

    /**
     * 
     */
	public static function noPayout()
	{
		return new static('Could not send payment to seller for some reason.');
	}

	public static function cantCreateAddress()
	{
		return new static('Could not create a payment address for this transaction.');
	}

	public static function cantCreateAccount()
	{
		return new static('Could not create an account for this transaction.');
	}
}
