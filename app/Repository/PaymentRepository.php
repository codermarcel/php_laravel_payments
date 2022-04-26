<?php

namespace App\Repository;

use App\BusinessLogic\Payment\PaymentService;
use App\BusinessLogic\Status\PaymentStatus;
use App\Entity\Payment;
use App\Repository\BaseRepository;

class PaymentRepository extends BaseRepository
{
	public function __construct()
	{
		parent::__construct(new Payment);
	}

	public function getPaymentsForUserWithIdAndProductId($user_id, $product_id)
	{
		return $this->model
			->where('product_id', $product_id)
			->with(['product' => function ($query) use($user_id){
			    $query->where('user_id', '=', $user_id);
			}])->get();
	}

	public function findByPaypalTransactionId($input)
	{
		return $this->model->where('service_id', '=', $input)->first();
	}

	public function getByTransactionId($input)
	{
		return $this->model->where('transaction_id', '=', $input)->firstOrFail();
	}

	/**
	 * Find payment with a product_id $product_id and email $email
	 * 
	 * @return null | App\Entity\Payment
	 */
	public function findLatestPayment($product_id, $email, $paymentService)
	{
		PaymentService::ensureValidValue($paymentService);

		return $this->model
			->where('product_id', $product_id)
			->where('customer_email', $email)
			->where('payment_service', $paymentService)
			->latest()
			->first();
	}
}
