<?php 

namespace App\Service\Payment\Paypal;

use App\BusinessLogic\Payment\PaymentService as PaymentEnum;
use App\Contracts\Payment\Bitcoin\TransactionBuilder;
use App\Entity\Product;
use App\Exceptions\ClientException\PaymentException;
use App\Exceptions\ClientException\PaypalException;
use App\Exceptions\ClientException\ProductException;
use App\Repository\PaypalProfileRepository;
use App\Service\Jwt\JwtBuilder;
use App\Service\Payment\PaymentService;
use App\Service\Payment\Paypal\PaypalFoundation;
use Ramsey\Uuid\Uuid;

class PaypalTransactionBuilder implements TransactionBuilder
{
	private $profiles;
	private $paymentService;

	public function __construct(PaypalProfileRepository $profiles, PaymentService $paymentService)
	{
		$this->profiles = $profiles;
		$this->paymentService = $paymentService;
	}

	/**
	 * Make a transaction.
	 *
	 * @return App\Entity\Payment
	 */
	public function make(Product $product, $email)
	{
		$this->ensureSellerAcceptsPaypal($product->user->id);

		return $this->paymentService->createPaypalPayment($product, $email);
	}

	/**
	 * Ensure seller can create paypal payments.
	 */
	private function ensureSellerAcceptsPaypal($user_id)
	{
		$paypal_profile = $this->profiles->findByUserId($user_id);

		if (is_null($paypal_profile))
		{
			throw PaypalException::noProfile();
		}

		if (! $paypal_profile->enabled)
		{
			throw PaypalException::notEnabled();
		}

		if (empty($paypal_profile->paypal_email))
		{
			throw PaypalException::notConfigured();
		}
	}
}