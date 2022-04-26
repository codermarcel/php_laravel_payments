<?php

namespace App\Exceptions\ClientException;

use App\Entity\Product;
use App\Entity\user;
use App\Exceptions\ClientException;

class ProductException extends ClientException
{
	public function __construct($message, $code = 400)
	{
		parent::__construct($message, $code);
	}

    public static function banned()
    {
        return new static('This product can not be purchased because it is currently suspended.');
    }

    public static function notEnabled()
    {
        return new static('This product can not be purchased because the seller did not enable it.');
    }
}
