<?php

namespace App\Service\Payment\Coinbase;

use App\BusinessLogic\Money\BTC;
use App\BusinessLogic\Payment\PaymentService as PaymentEnum;
use App\BusinessLogic\Payment\ValidServiceTrait;
use App\BusinessLogic\Status\PaymentStatus;
use App\Entity\Payment;
use App\Service\Payment\Coinbase\CoinbaseClient;
use App\Service\Payment\Coinbase\CoinbaseCore;
use App\Service\Payment\PaymentService;
use Coinbase\Wallet\Resource\Account;
use Illuminate\Http\Request;

class CoinbaseTransactionSearcher extends CoinbaseCore
{
	private $paymentService;

	use ValidServiceTrait;

	/**
	 * var client
	 */
	protected $client = null;

	/**
	 * Constructor
	 */
	public function __construct(CoinbaseClient $client, PaymentService $paymentService = null)
	{
		$this->client = $client;
		$this->paymentService = $paymentService ?: app(PaymentService::class);
	}

	public function hasSuccesfulPayment(Payment $payment)
	{
		$this->paymentService->ensureCoinbaseService($payment);

		$hasPaid = $this->hasPaid($payment);

		return $hasPaid ? $this->paymentService->moveToInvoice($payment) : false;
	}

	private function hasPaid(Payment $payment)
	{
		try {
			//$payment->transaction_id
			$account = $this->client->findAccount('27995de6-2cc5-4422-a20c-211faee5ca7e');

			$real = BTC::fromBtc($account->getBalance()->getAmount());
			$expected = $payment->price_other;
			$this->paymentService->ensureWithinErrorMargin($real, $expected);

			return true;
		} catch (\Exception $e) {
		}

		return false;
	}
}