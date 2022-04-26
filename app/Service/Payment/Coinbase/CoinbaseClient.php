<?php

namespace App\Service\Payment\Coinbase;

use App\BusinessLogic\Money\BTC;
use App\BusinessLogic\Money\USD;
use App\Entity\User;
use App\Exceptions\ClientException\CoinbaseException;
use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Resource\Account;
use Illuminate\Contracts\Cache\Repository as Cache;

class CoinbaseClient
{
	/**
	 * All cache keys.
	 */
	private $cache_keys = ['coinbase.accounts', 'coinbase.rates.btc'];

	/**
	 * vars.
	 */
	private $cache = null;
	private $client = null;
	private $isSandbox = false;

	public function __construct($api_key, $api_secret, $sandbox = false)
	{
		$this->api_key = $api_key; //needed to generate the cache key.

		$url = $sandbox ? Configuration::SANDBOX_API_URL : Configuration::DEFAULT_API_URL;
		$url = env('COINBASE_URL', $url);

		$this->isSandbox = $url === Configuration::SANDBOX_API_URL ? 'yes' : 'no';

        $configuration = Configuration::apiKey($api_key, $api_secret);
        $configuration->setApiUrl($url);

        $client = Client::create($configuration);
        $client->enableActiveRecord();
        $this->client = $client;

        $this->cache = app(Cache::class);
	}

	public function getClient()
	{
		return $this->client;
	}

	public function getCache()
	{
		return $this->cache;
	}

	/**
	 * Create the account (wallet) on blockchain.
	 */
	public function createAccount($name)
	{
		$account = new Account;
		$account->setName($name);

        $this->client->createAccount($account);

        if ($this->getFromLastResponse('data.name') !== (string) $name)
        {
        	throw CoinbaseException::cantCreateAccount();
        }

        return new Account($this->getFromLastResponse('data.resource_path')); //return $account !?
	}

	/**
	 * Find account by its name.
	 */
	public function findAccount($name)
	{
		foreach ($this->getAccounts() as $account)
		{
			if ($account->getName() === $name)
			{
				return $account;
			}
		}

		return null;
	}

	/**
	 * Delete all empty accounts (with no balance.)
	 */
	public function deleteAccounts()
	{
		foreach($this->getAccounts() as $account)
		{
			if ($account->getBalance()->getAmount() > 0)
			{
				continue; //avoid api call if possible.
			}

			try {
				$this->getClient()->deleteAccount($account);
			} catch (\Exception $e) {
				
			}
		}
	}

	/**
	 * Get all accounts and cache result for 0.1 minutes.
	 */
	public function getAccounts()
	{
		$minutes = 0.1;
		$key = $this->buildKey(0);

		return $this->getCache()->remember($key, $minutes, function() {
		    return $this->getClient()->getAccounts();
		});
	}

	/**
	 * Response stuff.
	 */
	public function getFromLastResponse($name)
	{
		return array_get($this->getClient()->decodeLastResponse(), $name);
	}

	public function debug()
	{
		dd($this->getClient()->decodeLastResponse());
	}

	/**
	 * Alias for the calculatePrice method.
	 */
	public function getBtc(USD $usd)
	{
		return $this->calculatePrice($usd);
	}

	/**
	 * Convert USD to BTC amount.
	 *
	 * @param  App\BusinessLogic\Money\USD
	 * @return App\BusinessLogic\Money\BTC
	 */
	public function calculatePrice(USD $usd)
	{
		$btc_rate = array_get($this->getRates(), 'rates.BTC');

		return BTC::fromBtc($usd->toDollars() * $btc_rate);
	}

	private function getRates()
	{
		$minutes = 1;
		$key = $this->buildKey(1);

		return $this->getCache()->remember($key, $minutes, function() {
		    return $this->getClient()->getExchangeRates();
		});
	}

	private function buildKey($index)
	{
		$base_name = $this->cache_keys[$index];

		return "$base_name." . md5($this->api_key . $this->isSandbox);
	}

	public function clearCache($index = null)
	{
		foreach($this->cache_keys as $key => $value)
		{
			if ($key === $index || $index === null);
			{
				$this->forgetCache($index);
			}
		}
	}

	private function forgetCache($index)
	{
		$key = $this->buildKey($index);
		$this->getCache()->forget($key);
	}

    /**
     * Redirect calls to the client.
     */
    public function __call($method, array $args)
    {
        return call_user_func_array([$this->client, $method], $args);
    }
}