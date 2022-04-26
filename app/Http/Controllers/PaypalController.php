<?php

namespace App\Http\Controllers;

use App\Events\PurchaseConfirmedEvent;
use App\Repository\ProductRepository;
use App\Service\Api\Api;
use App\Service\Payment\PaymentJwtBuilder;
use App\Service\Payment\Paypal\PaypalIpn;
use App\Service\Payment\Paypal\PaypalTransactionBuilder;
use App\Service\Payment\Paypal\PaypalTransactionSearcher;
use App\Service\Payment\Paypal\TestPaypalIpn;
use Illuminate\Http\Request;

class PaypalController extends AbstractController
{
	private $builder;
	private $searcher;

	public function __construct(PaypalTransactionBuilder $builder, PaypalTransactionSearcher $searcher)
	{
		$this->builder = $builder;
		$this->searcher = $searcher;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request, ProductRepository $products, PaymentJwtBuilder $jwt)
	{
		$product = $products->getByPrimaryKey($request->input('product_id'));
        $product->setCryptoProvider(AesService::fromRawKey($request->raw_key, $request->signature, $product->user));
		$email = $request->input('email');

		$payment = $this->builder->make($product, $email);

		$additional = [
			'ipn_callback' => route('paypal.callback'),
			'jwt'          => $jwt->createJwt($payment->transaction_id),
		];

		return Api::paymentResponse($payment, $additional);
	}

	/**
	 * Process the paypal callback.
	 *
	 * "PayPal expects to receive a response to an IPN message within 30 seconds. 
	 * Consequently, your listener must not perform time-consuming operations (such as updating a database) before responding to an IPN."
	 *
	 */
	public function callback(Request $request)
	{
		$api = app(TestPaypalIpn::class); //TestPaypalIpn
		$api->setSandbox(true);

		if ($api->isVerified($request->all()))
		{
			$payment = $this->searcher->processCallback($request, true); //pass in true to support sandbox mode.
			
			event(new PurchaseConfirmedEvent($payment));

			return Api::ok();
		}

		return 'Nice try, kappa';
	}
}