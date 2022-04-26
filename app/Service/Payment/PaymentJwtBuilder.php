<?php 

namespace App\Service\Payment;

use App\Service\Jwt\JwtBuilder;

class PaymentJwtBuilder
{
	public function createJwt($transaction_id)
	{
		$jwt = new JwtBuilder(true, false);
		$jwt->setSubject($transaction_id);
		$jwt->setExpirationIn($this->getExpireDuration());

		return $jwt->getToken();
	}

	/**
	 * Return payment jwt in minutes * 60 
	 */
	private function getExpireDuration()
	{
		return config('PAYMENT_JWT_EXPIRE_TIME_MINUTES') * 60;
	}
}