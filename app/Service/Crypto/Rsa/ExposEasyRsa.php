<?php

namespace App\Service\Crypto\Rsa;

use App\Contracts\Crypto\RsaCryptoInterface;
use ParagonIE\EasyRSA\EasyRSA;

class ExposEasyRsa extends EasyRSA
{
	/**
	 *
	 */
	public function rsaEnc($message, $public_key)
	{
		return static::rsaEncrypt($message, $public_key);
	}

	/**
	 *
	 */
	public function rsaDec($ciphertext, $private_key)
	{
		return static::rsaDecrypt($ciphertext, $private_key);
	}
}