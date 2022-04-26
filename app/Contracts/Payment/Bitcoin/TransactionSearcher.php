<?php

namespace App\Contracts\Payment\Bitcoin;

use App\Entity\Payment;
use App\Entity\Product;

interface TransactionSearcher
{
	/**
	 * Find a confirmed payment.
	 *
	 * @param  App\Entity\Payment
	 * @return boolean true|false
	 */
	public function hasConfirmedPayment(Payment $payment);

	/**
	 * Find an unconfirmed payment.
	 *
	 * @param  App\Entity\Payment
	 * @return boolean true|false
	 */
	public function hasUnconfirmedPayment(Payment $payment);

	/**
	 * Try to find a pending transaction
	 * 
	 * @return null|App\Entity\Payment
	 */
	public function findPendingTransaction(Product $product, $email);

	/**
	 * Get the total confirmed payment amount in btc.
	 *
	 * @return App\BusinessLogic\Money\BTC
	 */
	public function getTotalConfirmedBtcAmount(Payment $payment);
}
