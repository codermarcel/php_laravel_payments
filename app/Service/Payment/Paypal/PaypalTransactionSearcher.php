<?php 

namespace App\Service\Payment\Paypal;

use App\BusinessLogic\Money\USD;
use App\BusinessLogic\Payment\PaymentService as PaymentEnum;
use App\BusinessLogic\Status\PaymentStatus;
use App\Events\PurchaseConfirmedEvent;
use App\Exceptions\ClientException\PaymentException;
use App\Repository\PaymentRepository;
use App\Service\Jwt\JwtParser;
use App\Service\Jwt\PaypalJwtValidator;
use App\Service\Payment\PaymentService;

/**
 * This class contains the core paypal logic.
 */
class PaypalTransactionSearcher
{
	private $payments;
	private $paymentService;
	private $sandboxMode = false;

	public function __construct(PaymentRepository $payments, PaymentService $paymentService)
	{
		$this->payments = $payments;
		$this->paymentService = $paymentService;
	}

	public function processCallback($request, $sandboxMode = false)
	{
		$this->sandboxMode = $sandboxMode;
		$searcher = JwtParser::fromString($request->input('custom'), new PaypalJwtValidator);
		$payment = $this->payments->getByTransactionId($searcher->getSubject());
		$additional = ['service_id' => $request->input('txn_id')];

		$result = $this->isValidPayment($request, $payment);

		if ($result !== true)
		{
			$this->paymentService->setAsFailedPayment($payment, $result);
			abort(400);
		}

		return $this->paymentService->returnSuccessfulPayment($payment, PaymentEnum::PAYPAL, $additional);
	}

	/**
	 * @return null|string
	 */
	private function isValidPayment($request, $payment)
	{
		$reason = true;
		
		if ($request->input('test_ipn') === '1') //sandbox mode
		{
			if ($this->sandboxMode !== true || ! app()->environment(['test', 'testing', 'local']))
			{
				return 'We can not process sandbox payments';
			}
		}

		if ($request->input('mc_currency') !== 'USD')
		{
			return 'Invalid currency. Only USD as currency is supported.';
		}

		if ($request->input('payment_status') !== 'Completed')
		{
			return 'Invalid payment_status';
		}

		if ($result = $this->invalidPayAmount($request, $payment))
		{
			return $result;
		}

		return $reason;
	}

	/**
	 * Make sure that the paid amount >= the expected amount.
	 */
	private function invalidPayAmount($request, $payment)
	{
		$reason = null;

		$real = USD::fromDollars($request->input('mc_gross'));
		$price = $payment->price_usd;

		if ( ! USD::biggerOrEquals($real, $price))
		{
			$reason = sprintf(
				'The payment was less than expected. paid amount (%s), expected amount (%s) (values are in pennies)', 
				$real->toPennies(), 
				$price->toPennies()
			);
		}

		return $reason;
	}
}