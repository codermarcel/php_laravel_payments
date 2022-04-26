<?php

namespace App\Service\Crypto\Aes;

use App\Contracts\Crypto\AesCryptoInterface;
use App\Entity\User;
use App\Exceptions\ServerException\CryptoException;
use App\Service\Crypto\Aes\DefuseAes;
use App\Service\Crypto\Aes\DummyAes;
use App\Service\Crypto\Rsa\RsaService;
use Defuse\Crypto\Crypto;
use Exception;
use ParagonIE\EasyRSA\Exception\InvalidCiphertextException;

class AesService
{
	private $encryption_key;
	private $provider;

	/**
	 * Constructor.
	 */
	public function __construct($encryption_key, AesCryptoInterface $provider = null)
	{
		$this->encryption_key = $encryption_key;

		$this->provider = $provider ?: app(DummyAes::class);
	}

	public static function fromUser(User $user, AesCryptoInterface $provider = null)
	{
		return new static($user->encryption_profile->encryption_key, $provider);
	}

	public static function fromRawKey($raw_key, $signature, User $user)
	{
		$rsa = RsaService::fromUser($user);

		if ( ! $rsa->verify($raw_key, $signature))
		{
			throw CryptoException::cantVerify();
		}

		return new static($raw_key);
	}


	/**
	 */
	public function generateEncryptionKey()
	{
		return $this->provider->generateEncryptionKey();
	}

	/**
	 * Dont base64 encode here, let the providers do that.
	 */
	public function encrypt($message)
	{
		return $this->provider->encrypt($message, $this->getEncryptionKey());
	}

	/**
	 * Dont base64 decode here, let the providers do that.
	 */
	public function decrypt($ciphertext)
	{
		return $this->provider->decrypt($ciphertext, $this->getEncryptionKey());
	}


	/**
	 * Getters and setters.
	 */
	public function setEncryptionKey($input)
	{
		$this->encryption_key = $input;
	}

	public function getEncryptionKey()
	{
		return $this->encryption_key;
	}
}