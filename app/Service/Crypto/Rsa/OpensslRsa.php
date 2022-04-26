<?php

namespace App\Service\Crypto\Rsa;

use App\Contracts\Crypto\RsaCryptoInterface;

class OpensslRsa implements RsaCryptoInterface
{
	/**
	 * Encrypt
	 */
	public function encrypt($message, $public_key)
	{
		openssl_public_encrypt($message, $encrypted, $public_key);

		return base64_encode($encrypted);
	}

	/**
	 * Decrypt
	 */
	public function decrypt($ciphertext, $private_key)
	{
		$ciphertext = base64_decode($ciphertext);

		openssl_private_decrypt($ciphertext, $decrypted, $private_key);

		return $decrypted;
	}

	/**
	 * Sign
	 */
	public function sign($message, $private_key)
	{
		$result  = openssl_sign($message, $signature, $private_key, $this->getOpensslAlgo());

		if ($result === true)
		{
			return $signature; //base64_decode($signature);
		}

		throw CryptoException::opensslCantSign();
	}

	/**
	 * Verify
	 */
	public function verify($data, $signature, $public_key)
	{
		//$signature = base64_decode($signature);
		$result = openssl_verify($data, $signature, $public_key, $this->getOpensslAlgo());

		if ($result === 1)
		{
			return true;
		}

		if ($result === 0)
		{
			return false;
		}

		throw CryptoException::opensslVerify();
	}

	/**
	 * Algorithm
	 */
	private function getOpensslAlgo()
	{
		return 'sha256';
	}
}