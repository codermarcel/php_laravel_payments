<?php

namespace App\Http\Controllers;

use App\BusinessLogic\Money\BTC;
use App\BusinessLogic\Payment\PaymentService;
use App\Http\Controllers\AbstractController;
use App\Repository\PaymentRepository;
use App\Repository\ProductRepository;
use App\Service\Api\Api;
use App\Service\Jwt\CoinbaseJwtValidator;
use App\Service\Jwt\JwtParser;
use App\Service\Payment\Coinbase\CoinbaseClient;
use App\Service\Payment\Coinbase\CoinbaseTransactionBuilder;
use App\Service\Payment\Coinbase\CoinbaseTransactionSearcher;
use App\Service\Payment\PaymentJwtBuilder;
use Coinbase\Wallet\Resource\Address;
use Illuminate\Http\Request;

class CoinbaseController extends AbstractController
{
    private $products;
    public function __construct(ProductRepository $products)
    {
        $this->products = $products;
    }

    /**
     * Create payment.
     *
     */
    public function create(Request $request, PaymentJwtBuilder $jwt)
    {
        $product = $this->products->getByPrimaryKey($request->input('product_id'));
        $product->setCryptoProvider(AesService::fromRawKey($request->raw_key, $request->signature, $product->user));
        $email = $request->input('email');

        $builder = CoinbaseTransactionBuilder::fromProduct($product);

        $payment = $builder->make($product, $email);
        $btc_price = BTC::fromSatoshi($payment->price_other);

        $additional = [
            'btc_address'   => $payment->pay_to_address,
            'price_btc'     => $btc_price->toBtc(),
            'price_satoshi' => $btc_price->toSatoshi(),
        ];

        return Api::paymentResponse($payment, $additional);
    }

    /**
     * Process the paypal callback.
     *
     */
    public function callback(Request $request, PaymentRepository $payments)
    {
        $parser = JwtParser::fromString($request->input('jwt'), new CoinbaseJwtValidator); //we can trust the request now. (because only coinbase has the jwt)
        $payment = $payments->getByTransactionId($parser->getSubject());
        $searcher = CoinbaseTransactionSearcher::fromProduct($payment->product);

        $payment = $searcher->hasSuccesfulPayment($payment);

        if ($payment !== false)
        {
            event(new PurchaseConfirmedEvent($payment));

            return Api::ok();
        }

        return Api::fail();
    }
}