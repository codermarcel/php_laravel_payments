<?php

namespace App\Service\Crypto\Rsa;

use App\Contracts\Crypto\RsaCryptoInterface;

class DummyRsa implements RsaCryptoInterface
{
	/**
	 *
	 */
	public function encrypt($message, $public_key)
	{
		return $message;
	}

	/**
	 *
	 */
	public function decrypt($ciphertext, $private_key)
	{
		return $ciphertext;
	}


	/**
	 * 
	 */
	public function sign($message, $private_key)
	{
		return sha1($message . $private_key);
	}

	/**
	 * 
	 */
	public function verify($message, $signature, $public_key)
	{
		return true;
	}
}