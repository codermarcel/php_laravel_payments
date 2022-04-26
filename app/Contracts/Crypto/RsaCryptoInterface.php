<?php

namespace App\Contracts\Crypto;

interface RsaCryptoInterface
{
	/**
	 * Encrypt data $message
	 */
	public function encrypt($message, $public_key);

	/**
	 * Decrypt $ciphertext
	 */
	public function decrypt($ciphertext, $private_key);

	/**
	 * Create rsa signature.
	 */
	public function sign($message, $private_key);

	/**
	 *	Verify rsa signature.
	 */
	public function verify($message, $signature, $public_key);
}