<?php 

namespace App\Service\Payment;

use App\BusinessLogic\Payment\PaymentService;
use App\BusinessLogic\Status\PaymentStatus;
use App\Contracts\Money\CurrencyInterface;
use App\Entity\Invoice;
use App\Entity\Payment;
use App\Entity\Product;
use App\Exceptions\ClientException\PaymentException;
use App\Exceptions\ClientException\ProductException;
use App\Repository\PaymentRepository;
use App\Service\Crypto\Rsa\RsaService;
use App\Service\EntityService;
use App\Service\Time\Time;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class PaymentService
{
	private $service;

	public function __construct(EntityService $service)
	{
		$this->service = $service;
	}

	public function ensureCoinbaseService(Payment $payment)
	{
		if ($payment->payment_service !== PaymentService::COINBASE)
		{
			throw PaymentException::invalidService();
		}
	}

	public function createPaypalPayment(Product $product, $email)
	{
		$paymentService = PaymentService::PAYPAL;

		return $this->createPaymentEntry(Uuid::uuid4(), $product, $email, $paymentService);
	}

	public function createCoinbaseEntry($transaction_id, Product $product, $email, $price_btc, $btc_address)
	{
		$paymentService = PaymentService::COINBASE;

		return $this->createPaymentEntry($transaction_id, $product, $email, $paymentService, null, $price_btc, $btc_address);
	}

	private function createPaymentEntry(Uuid $transaction_id, $product, $email, $payment_service, $service_id = null, $price_other = null, $pay_to_address = null)
	{
		PaymentService::ensureValidValue($payment_service);

		$price_other = $price_other instanceof CurrencyInterface ? $price_other->toSmallestUnit() : $price_other;

		$payment = $this->hasAlreadyPayment($product, $email, $payment_service);

		if ( ! is_null($payment))
		{
			return $payment;
		}

		if ( ! $product->enabled)
		{
			throw ProductException::notEnabled();
		}

		return $this->insertPayment($transaction_id, $product, $email, $payment_service, $service_id, $price_other, $pay_to_address);
	}

	/**
	 * Create the payment entry.
	 */	
	private function insertPayment(Uuid $transaction_id, $product, $email, $payment_service, $service_id = null, $price_other = null, $pay_to_address = null)
	{
		$payment = new Payment;
		$payment->transaction_id  = $transaction_id;
		$payment->product_id      = $product->id;
		$payment->customer_email  = $email;
		$payment->price_usd 	  = $product->price;
		$payment->price_other 	  = $price_other;
		$payment->service_id      = $service_id;
		$payment->payment_service = $payment_service;
		$payment->pay_to_address  = $pay_to_address;

		return $this->updateOrCreate($payment);
	}

	public function moveToInvoice(Payment $payment, array $additional = [])
	{
		$payment->fill($additional);
		$payment->validateUpdate(); //since we dont save the model, the validation is never triggered and thus we need to manually trigger it.

		$org_payment = $payment->replicate(); //clone this since we will delete the original in the database but need the model for a event.
		$provider = RsaService::fromUser($payment->product->user); //create rsa provider with the sellers public key.

		$result = DB::transaction(function () use($payment, $provider){
			$data = $this->createInvoiceData($payment);
			$invoice = new Invoice($data, $provider);

			return $invoice->save() && $payment->delete();
		});

		if ( ! $result)
		{
			throw PaymentException::cantMove();
		}

		return $org_payment;
	}

	private function createInvoiceData(Payment $payment)
	{
		$data = array_except($payment->toArray(), ['id']);
		$data['price_usd'] = $payment->price_usd->toSmallestUnit();
		$data['price_other'] = $payment->price_other ? $payment->price_other->toSmallestUnit() : null;

		return $data;
	}

	public function setAsFailedPayment($payment, $reason)
	{
		$payment->status = PaymentStatus::ERROR;
		$payment->reason = $reason;

		return $this->updateOrCreate($payment);
	}

	/**
	 * Update or create
	 */
	private function updateOrCreate($payment)
	{
		return $payment->ensureSaved();
	}


	/**
	 * Figure out if a payment already exists for the given service.
	 *
	 * @return null|App\Entity\Payment
	 */
	public function hasAlreadyPayment($product, $email, $paymentService)
	{
		$payments = app(PaymentRepository::class);

		$payment = $payments->findLatestPayment($product->id, $email, $paymentService);

		if ( ! is_null($payment) && $this->paymentIsRecent($payment))
		{
			return $payment;
		}

		return null;
	}

	/**
	 * Check if the user made a successful purchase or not.
	 *
	 * @throws App\Exceptions\ClientException\PaymentException
	 * @return false | App\Entity\Payment
	 */
	public function returnSuccessfulPayment(Payment $payment, $paymentService, $additional = [])
	{
		PaymentService::ensureValidValue($paymentService);

		if ( ! $payment->payment_service === $paymentService)
		{
			throw PaymentException::invalidService();
		}

		return $this->moveToInvoice($payment, $additional);
	}

    /**
     * Determine if the payment was recently created.
     *
     * @param  array  $token
     * @return bool
     */
    public function paymentIsRecent(Payment $payment)
    {
        return ! $this->paymentIsNotRecent($payment);
    }

    /**
     * Determine if the payment was NOT recently created.
     *
     * @param  array  $token
     * @return bool
     */
    public function paymentIsNotRecent(Payment $payment)
    {
        $expirationTime = strtotime($payment['created_at']) + $this->getRecentTime();

        return $expirationTime < Time::now();
    }

    /**
     * Return how many seconds can pass before a new payment entry is created
     *
     * Note : this time should be lower than the valid time, since the customer
     * needs some time to do the payment.
     *
     * Defaults to getValidTime - 2 minutes.
     */
    private function getRecentTime()
    {
    	return $this->getValidTime() - 120;
    }

    /**
     * Return how many seconds can pass before the payment is too late.
     */
    private function getValidTime()
    {
    	$minutes = env('PAYMENT_VALID_TIME_MINUTES', 15);

    	return $minutes * 60;
    }

	/**
	 * Default error margin in percent.
	 */
    private function getDefaultErrorMargin()
    {
    	return env('PAYMENT_ERRO_MARGIN_PERCENT', 1);
    }

	/**
	 * Check if the transaction is still within the error margin.
	 *
	 * @return boolean true|false
	 */
	public function ensureWithinErrorMargin(CurrencyInterface $expected, CurrencyInterface $real, $error_margin_in_procent = null)
	{
		$error_margin_in_procent = $error_margin_in_procent ?: $this->getDefaultErrorMargin();

		if ( ! $this->isWithinErrorMargin($expected, $real, $error_margin_in_procent))
		{
			throw PaymentException::outsideMargin();
		}
	}

	/**
	 * Check if the transaction is still within the error margin.
	 *
	 * @return boolean true|false
	 */
	private function isWithinErrorMargin(CurrencyInterface $expected, CurrencyInterface $real, $error_margin_in_procent)
	{
		if ( ! $error_margin_in_procent > 0)
		{
			return true;
		}

		$real = $real->toSmallestUnit();
		$expected = $real->toSmallestUnit();

		$error_margin = $expected / 100 * $error_margin_in_procent;

		return ($expected - $error_margin) >= $real;
	}
}