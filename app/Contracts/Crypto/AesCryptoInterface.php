<?php

namespace App\Contracts\Crypto;

interface AesCryptoInterface
{
	/**
	 * Generate a secure and random encryption key.
	 *
     * @return $string encryption key
	 */
	public function generateEncryptionKey();

	/**
	 * Encrypt and authenticate message.
	 *
	 * @return string $ciphertext
	 */
	public function encrypt($message, $key);

	/**
	 * Decrypt input ciphertext 
	 *
	 * @param string   $ciphertext
	 * @return string  $decrypted input
	 */
	public function decrypt($ciphertext, $key);
}