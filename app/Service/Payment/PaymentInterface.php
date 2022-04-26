<?php 

namespace App\Service\Payment;

use App\Entity\Payment;
use App\Entity\Product;
use Closure;

interface PaymentInterface
{
	/**
	 * 	@return null|App\Entity\Payment
	 */
	public function findRecentPayment();

	/**
	 * Find a recent payment or create a new one.
	 *
	 * @throws App\Exceptions\ClientException\PaymentException
	 * @return App\Entity\Payment
	 */
	public function getPaymentEntry(Product $product, $email, $paymentService, Closure $callback);

	/**
	 * Check whether or not a payment is valid.
	 *
	 * @throws App\Exceptions\ClientException\PaymentException
	 * @return void
	 */
	public function madeSuccessfulPurchase(Payment $payment, $paymentService, $additional = [], Closure $callback);
}