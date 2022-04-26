<?php

namespace App\Http\Controllers;

use App\Entity\Decorator\PaymentDecorator;
use App\Repository\PaymentRepository;
use App\Service\Api\Api;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class PaymentController extends AbstractController
{
	private $payments;

	public function __construct(PaymentRepository $payments)
	{
		$this->payments = $payments;
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $product_id = $request->input('product_id');
    	$user = $request->user();

        $payments =  $this->payments->getPaymentsForUserWithIdAndProductId($user->id, $product_id);
        $payments = PaymentDecorator::decorateCollection($payments);

    	return (new Api)
            ->set('payments', $payments)
            ->build();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $transaction_id = $request->input('transaction_id');

        $payment =  $this->payments->getByTransactionId($transaction_id);
        $payment = new PaymentDecorator($payment);

        return (new Api)
            ->set('payment', $payment)
            ->build();
    }
}