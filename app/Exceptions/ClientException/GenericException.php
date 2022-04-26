<?php

namespace App\Exceptions\ClientException;

use App\Entity\Product;
use App\Entity\user;
use App\Exceptions\ClientException;

class GenericException extends ClientException
{
	public function __construct($message = 'Something went wrong', $code = 400)
	{
		parent::__construct($message, $code);
	}

    public static function userIsNotConfirmed(User $user)
    {
        $username = $user->username;

        return new static("The user ($username) has not confirmed his account.");
    }

    public static function noEmailTemplate(Product $product = null)
    {
        return new static('The Product you are trying to purchase is not set up correctly.');
    }

    public static function noBtcPayoutAddress(User $user)
    {
        $username = $user->username;

        return new static("The user ($username) has not yet set a btc payout address.");
    }

    public static function password($length)
    {
        return new static("Your password has to have at least $length characters.");
    }
}
