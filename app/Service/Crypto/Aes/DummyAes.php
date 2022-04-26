<?php

namespace App\Service\Crypto\Aes;

use App\Contracts\Crypto\AesCryptoInterface;
use Exception;
use \Defuse\Crypto\Crypto;

class DummyAes implements AesCryptoInterface
{
	/**
	 */
	public function generateEncryptionKey()
	{
		return str_random(10);
	}

	/**
	 */
	public function encrypt($message, $key)
	{
		return $message;
	}

	/**
	 */
	public function decrypt($ciphertext, $key)
	{
		return $ciphertext;
	}
}