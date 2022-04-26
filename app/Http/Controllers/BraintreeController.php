<?php

namespace App\Http\Controllers;

use Braintree\Configuration;
use Braintree\Transaction;
use Illuminate\Http\Request;

class BraintreeController extends AbstractController
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function pay(Request $request)
	{
		Configuration::environment('sandbox');
		Configuration::merchantId('yk2fq4gqshmx5yqb');
		Configuration::publicKey('3kshwg8hzjvdpvn8');
		Configuration::privateKey('eb321f67654cfb4c0945bacbc77d646b');


		$result = Transaction::sale([
		    'amount' => '1000.00',
		    'paymentMethodNonce' => 'nonceFromTheClient',
		    'options' => [ 'submitForSettlement' => true ]
		]);

		dd($result);

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