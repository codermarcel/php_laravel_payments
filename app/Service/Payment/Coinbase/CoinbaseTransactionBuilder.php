<?php

namespace App\Service\Payment\Coinbase;

use App\BusinessLogic\Payment\PaymentService as PaymentEnum;
use App\Contracts\Payment\Bitcoin\TransactionBuilder;
use App\Entity\Product;
use App\Entity\User;
use App\Exceptions\ClientException\CoinbaseException;
use App\Exceptions\ClientException\ProductException;
use App\Repository\CoinbaseProfileRepository;
use App\Repository\PaymentRepository;
use App\Service\Payment\Coinbase\CoinbaseClient;
use App\Service\Payment\Coinbase\CoinbaseCore;
use App\Service\Payment\PaymentJwtBuilder;
use App\Service\Payment\PaymentService;
use Coinbase\Wallet\Resource\Account;
use Coinbase\Wallet\Resource\Address;
use Ramsey\Uuid\Uuid;

class CoinbaseTransactionBuilder extends CoinbaseCore implements TransactionBuilder
{
	private $paymentService;
	private $profiles;
	protected $client = null;
	private $payments;

	public function __construct(CoinbaseClient $client, PaymentService $paymentService = null, CoinbaseProfileRepository $profiles = null)
	{
		$this->client         = $client;
		$this->paymentService = $paymentService ?: app(PaymentService::class);
		$this->profiles       = $profiles       ?: app(CoinbaseProfileRepository::class);
	}

	/**
	 * @return App\Entity\Payment
	 */
	public function make(Product $product, $email)
	{
		$this->ensureCoinbaseProfileIsOk($product->user);

		if ( ! is_null($result = $this->paymentService->hasAlreadyPayment($product, $email, PaymentEnum::COINBASE)))
		{
			return $result;
		}

		$transaction_id = Uuid::uuid4();
		$account = $this->client->createAccount($transaction_id);
		$btc_address = $this->createAddressForAccount($account, $transaction_id);
		$price_btc = $this->client->calculatePrice($product->price);
		$payment = $this->paymentService->createCoinbaseEntry($transaction_id, $product, $email, $price_btc, $btc_address);

		return $payment;
	}

	private function ensureCoinbaseProfileIsOk(User $user)
	{
		$profile = $this->profiles->findByUserPrimaryKey($user->getIdentifier());

		if (is_null($profile))
		{
			throw CoinBaseException::noProfile();
		}

		if (! $profile->enabled)
		{
			throw CoinBaseException::notEnabled();
		}

		if (empty($profile->api_secret) || empty($profile->api_key))
		{
			throw CoinBaseException::notConfigured();
		}
	}

	private function createAddressForAccount($account, $transaction_id)
	{
		$address = new Address(['name' => $transaction_id]);
		$address->setCallbackUrl($this->getCallbackUrl($transaction_id));

        $this->client->createAccountAddress($account, $address);

        if ($this->client->getFromLastResponse('data.name') !== (string) $transaction_id)
        {
        	throw CoinbaseException::cantCreateAddress();
        }

        return $this->client->getFromLastResponse('data.address');
	}

	/**
	 * Build the callback url with the jwt to ensure a safe callback.
	 */
	private function getCallbackUrl($transaction_id)
	{
		$jwt = app(PaymentJwtBuilder::class);

		$jwt_value = $jwt->createJwt($transaction_id);

		\Log::info('coinbase jwt => ' . $jwt_value);

		return route('coinbase.callback', ['jwt' => $jwt_value]);
	}
}