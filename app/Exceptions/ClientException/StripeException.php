<?php

namespace App\Exceptions\ClientException;

use App\Exceptions\ClientException;

class StripeException extends ClientException
{
    public static function noToken()
    {
        return new static('No stripe token has been submitted.');
    }
}
