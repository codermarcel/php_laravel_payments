<?php

namespace App\Service\Crypto\Rsa;

use App\Contracts\Crypto\RsaCryptoInterface;
use App\Service\Crypto\Rsa\ParagonRsa;

class PhpseclibRsa implements RsaCryptoInterface
{
	private $provider;

	public function __construct($provider = null)
	{
		$this->provider = $provider ?: new ExposEasyRsa;
	}

	/**
	 *
	 */
	public function encrypt($message, $public_key)
	{
		$encrypted = $this->provider->rsaEnc($message, $public_key);
		
		return base64_encode($encrypted);
	}

	/**
	 *
	 */
	public function decrypt($ciphertext, $private_key)
	{
		$ciphertext = base64_decode($ciphertext);

		return $this->provider->rsaDec($ciphertext, $private_key);
	}
}