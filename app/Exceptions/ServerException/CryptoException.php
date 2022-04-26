<?php

namespace App\Exceptions\ServerException;

use App\Exceptions\ServerException;

class CryptoException extends ServerException
{
	/**
	 * @param mixed $message
	 * @param int 	$code
	 */
	public function __construct($message, $code = 500)
	{
		parent::__construct($message, $code);
	}

	public static function cantVerify()
	{
		return new static('Could not verify rsa signature.');
	}

	public static function opensslCantSign()
	{
		return new static('Openssl could not sign the message.');
	}

	public static function opensslVerify()
	{
		return new static('Openssl could not verify the signature.');
	}

	public static function noCryptoProvider()
	{
		return new static('No crypto provider has been specified.');
	}

	public static function noPublicKey()
	{
		return new static('Cannot encrypt or verify this message without a public key.');
	}

	public static function noPrivateKey()
	{
		return new static('Cannot decrypt or sign this message without a private key.');
	}

	public static function temperedCiphertext()
	{
		return new static('Cannot safely decrypt message.');
	}

	public static function notSafeDecrypt()
	{
		return new static('Cannot safely decrypt message.');
	}

	public static function notSafeEncrypt()
	{
		return new static('Cannot safely encrypt message.');
	}

	public static function notSafeKey()
	{
		return new static('Cannot safely create a key');
	}

	public static function badCrypto()
	{
		return new static('Uncaught crypto exception');
	}

	public static function opensslFail()
	{
		return new static('openssl_random_pseudo_bytes() failed.');
	}

	public static function opensslFunction()
	{
		return new static('The openssl_random_pseudo_bytes() function does not exist.');
	}

	public static function badLength($length, $required)
	{
		return new static("The minimum length is $required, you chose $length"); //chose, not choose (right?)
	}
}
