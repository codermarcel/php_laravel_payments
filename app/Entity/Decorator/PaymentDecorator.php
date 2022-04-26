<?php

namespace App\Entity\Decorator;

use App\BusinessLogic\Payment\PaymentService;
use App\BusinessLogic\Status\PaymentStatus;
use App\Entity\Payment;
use Illuminate\Database\Eloquent\Model;

class PaymentDecorator extends BaseDecorator
{
	public static function decorate(Model $payment)
	{
		$decorated = new static;
		
		$decorated->set('transaction_id', $payment->transaction_id);
		$decorated->set('status', PaymentStatus::asString($payment->status));
		$decorated->set('payment_service', $payment->payment_service);
		$decorated->set('customer_email', $payment->email);
		$decorated->set('price_usd', $payment->price_usd->toDollars());
		$decorated->set('price_usd_pennies', $payment->price_usd->toPennies());

		//skip if empty.
		$decorated->set('price_other', $payment->price_other);
		$decorated->set('pay_to_address', $payment->pay_to_address);

		return $decorated;
	}

	private function set($key, $value, $forceNull = false)
	{
		if ($forceNull || ! empty($value))
		{
			$this->$key = $value;
		}
	}
}
