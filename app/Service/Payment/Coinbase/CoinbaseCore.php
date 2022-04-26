<?php

namespace App\Service\Payment\Coinbase;

use App\Entity\Product;
use App\Entity\User;
use App\Exceptions\ClientException\CoinbaseException;
use App\Exceptions\ClientException\ProductException;
use App\Service\Payment\Coinbase\CoinbaseClient;

class CoinbaseCore
{
	public static function fromUser(User $user, $url = null)
	{
		$coinbase_profile = $user->coinbase_profile;

		if (is_null($coinbase_profile))
		{
			throw CoinbaseException::noProfile();
		}

		if ($coinbase_profile->enabled != true)
		{
			throw CoinbaseException::notEnabled();
		}

		$client = new CoinbaseClient($coinbase_profile->api_key, $coinbase_profile->api_secret, $url);

		return new static($client);
	}

	public static function fromProduct(Product $product, $url = null)
	{
		if ( ! $product->enabled)
		{
			throw ProductException::notEnabled();
		}

		return static::fromUser($product->user, $url);
	}

	public function getClient()
	{
		return $this->client;
	}
}