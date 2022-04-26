<?php

namespace App\Service\Crypto\Rsa;

use App\Contracts\Crypto\RsaCryptoInterface;
use ParagonIE\EasyRSA\EasyRSA;

class ParagonRsa implements RsaCryptoInterface
{
	/**
	 * comment to the EasyRsa implementation:
	 * the authentication checksum is secure because it is calculated from the encryption payload (which contains a random encryption key)
	 * thus an attacker could not change the hash without knowing the secret key (which is rsa encrypted)
	 */
	public function encrypt($message, $public_key)
	{
		return EasyRSA::encrypt($message, $public_key);
	}

	/**
	 *
	 */
	public function decrypt($ciphertext, $private_key)
	{
		return EasyRSA::decrypt($ciphertext, $private_key);
	}

	/**
	 * 
	 */
	public function sign($message, $private_key)
	{
		return EasyRSA::sign($message, $private_key);
	}

	/**
	 * 
	 */
	public function verify($message, $signature, $public_key)
	{
		return EasyRSA::verify($message, $signature, $public_key);
	}
}