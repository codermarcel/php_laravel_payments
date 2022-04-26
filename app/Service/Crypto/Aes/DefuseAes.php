<?php

namespace App\Service\Crypto\Aes;

use App\Contracts\Crypto\AesCryptoInterface;
use App\Exceptions\ServerException\CryptoException;
use Exception;
use ParagonIE\EasyRSA\Exception\InvalidCiphertextException;
use \Crypto;

class DefuseAes implements AesCryptoInterface
{
	/**
	 * Generate a secure and random encryption key.
	 *
	 * WARNING: Do NOT encode $key with bin2hex() or base64_encode(),
     * they may leak the key to the attacker through side channels.
     *
	 * @throws CryptoException
     * @return mixed
	 */
	public function generateEncryptionKey()
	{
		try {
		    $key = Crypto::createNewRandomKey();
		} catch (Exception $e) {
			throw CryptoException::notSafeKey();
		}

		return bin2hex($key); //have to.
	}

	/**
	 * Encrypt and authenticate message.
	 *
	 * @return string
	 */
	public function encrypt($message, $key)
	{
		$key = hex2bin($key);

		try {
		    $ciphertext = Crypto::encrypt($message, $key);
		} catch (Exception $e) {
			throw CryptoException::notSafeEncrypt();
		}

		return base64_encode($ciphertext);
	}

	/**
	 * 
	 * @return string  $decrypted input
	 */
	public function decrypt($ciphertext, $key)
	{
		$key = hex2bin($key);
		$ciphertext = base64_decode($ciphertext);

		try {
		    $decrypted = Crypto::decrypt($ciphertext, $key);
		} catch (InvalidCiphertextException $ex) { // VERY IMPORTANT, CATCH THIS.
			throw CryptoException::temperedCiphertext();
		} catch (Exception $ex) {
			throw CryptoException::notSafeDecrypt();
		}

		return $decrypted;
	}
}