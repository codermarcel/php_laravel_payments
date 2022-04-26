<?php

namespace App\Exceptions\ClientException;

use App\Exceptions\ClientException;

class PurchaseException extends ClientException
{
    public static function cantPurchase()
    {
        return new static('This purchase was not successful.');
    }
}
