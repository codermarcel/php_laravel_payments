<?php

namespace App\Service\Crypto\Rsa;

use App\Entity\User;
use App\Exceptions\ServerException\CryptoException;
use App\Service\Crypto\Rsa\DummyRsa;
use App\Service\Crypto\Rsa\OpensslRsa;
use App\Service\Crypto\Rsa\ParagonRsa;
use App\Service\Crypto\Rsa\PhpseclibRsa;

class RsaService
{
	private $public_key;
	private $private_key;
	private $provider;

	/**
	 * Constructor.
	 */
	public function __construct($public_key, $private_key = null, RsaCryptoInterface $provider = null)
	{
		$this->public_key = $public_key;
		$this->private_key = $private_key;
		$this->provider = $provider ?: new DummyRsa;
	}

	public static function fromUser(User $user, RsaCryptoInterface $provider = null)
	{
		$enc_profile = $user->encryption_profile;

		return new static($enc_profile->public_key, $enc_profile->private_key, $provider);
	}

	public static function viaProductRawKey(Product $product, $signature, $raw_key, RsaCryptoInterface $provider = null)
	{
		$instance = new static($product->user->encryption_profile->public_key, $raw_key, $provider);

		if ( ! $instance->verify($raw_key, $signature))
		{
			throw CryptoException::badSignature();
		}

		return $instance;
	}

	/**
	 *
	 */
	public function encrypt($message)
	{
		return $this->provider->encrypt($message, $this->getPublicKey());
	}

	/**
	 *
	 */
	public function decrypt($ciphertext)
	{
		return $this->provider->decrypt($ciphertext, $this->getPrivateKey());
	}

	/**
	 * 
	 */
	public function sign($message)
	{
		return $this->provider->sign($message, $this->getPrivateKey());
	}

	/**
	 * 
	 */
	public function verify($message, $signature)
	{
		return $this->provider->verify($message, $signature, $this->getPublicKey());
	}

	/**
	 * Public key setter
	 */
	public function setPublicKey($input)
	{
		$this->public_key = $input;
	}

	/**
	 * Public key getter
	 */
	private function getPublicKey()
	{
		if ($this->public_key === null)
		{
			throw CryptoException::noPublicKey();
		}

		return $this->public_key;
	}

	/**
	 * Private key setter
	 */
	public function setPrivateKey($input)
	{
		$this->private_key = $input;
	}

	/**
	 * Private key getter
	 */
	private function getPrivateKey()
	{
		if ($this->private_key === null)
		{
			throw CryptoException::noPrivateKey();
		}

		return $this->private_key;
	}
}