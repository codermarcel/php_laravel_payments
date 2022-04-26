<?php 

namespace App\Service\Payment\Braintree;

use Braintree\Configuration;
use Braintree\Transaction;

/**
 * This class contains the core braintree logic.
 */
class BraintreeFoundation
{
	private $setup = false;

	private function setup()
	{
		if (! $this->setup)
		{
			Configuration::environment('sandbox');
			Configuration::merchantId('yk2fq4gqshmx5yqb');
			Configuration::publicKey('3kshwg8hzjvdpvn8');
			Configuration::privateKey('eb321f67654cfb4c0945bacbc77d646b');
		}


		$result = Transaction::sale([
		    'amount' => '1000.00',
		    'paymentMethodNonce' => 'nonceFromTheClient',
		    'options' => [ 'submitForSettlement' => true ]
		]);

		if ($result->success) {
		    \Log::info("success!: " . $result->transaction->id);
		} else if ($result->transaction) {
		    Log::info("Error processing transaction:");
		    \Log::info("\n  code: " . $result->transaction->processorResponseCode);
		    \Log::info("\n  text: " . $result->transaction->processorResponseText);
		} else {
		    \Log::info("Validation errors: \n");
		    \Log::info($result->errors->deepAll());
		}

		
	}



}