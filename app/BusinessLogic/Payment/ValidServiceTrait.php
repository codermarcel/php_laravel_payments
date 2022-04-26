<?php

namespace App\BusinessLogic\Payment;

use App\BusinessLogic\Payment\PaymentService;
use App\Entity\Payment;
use App\Exceptions\ClientException\PaymentException;

trait ValidServiceTrait
{
	public function ensureValidService(Payment $payment, $input)
	{
		PaymentService::ensureValidValue($input);

		if ( ! $payment->payment_service === $input)
		{
			throw PaymentException::invalidService();
		}
	}
}