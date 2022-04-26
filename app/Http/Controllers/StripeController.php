<?php

namespace App\Http\Controllers;

use App\Entity\User;
use Illuminate\Http\Request;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;

class StripeController extends AbstractController
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function charge(Request $request, $plan_id)
	{
		\Log::info($request);

		$token  = $request->input('stripeToken');

		$email  = 'email@email.com'; //Get user email.

		$price = $plan_id == 1 ? 999 : 2999;
		
		return $this->doCharge($token, $email, $price);
	}

	private function doCharge($token, $email, $amount)
	{
		Stripe::setApiKey(env('STRIPE_SECRET'));

		$charge = Charge::create(array(
		  'amount'   => $amount,
		  'source'   => $token,
		  'currency' => 'usd'
		));

        $resp = $charge->getLastResponse()->json;
        

		dd($resp['status']);
	}
}