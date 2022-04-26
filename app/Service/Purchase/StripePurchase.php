<?php

namespace App\Service\Purchase;

use App\Contracts\Purchase\PurchaseProviderInterface;
use Illuminate\Http\Request;

class StripePurchase implements PurchaseProviderInterface
{
    /**
     * StripePurchase constructor.
     */
    public function __construct()
    {
        Stripe::setApiKey($this->getSecretKey());
    }

    public function purchase(Request $request, $price)
    {
        $token = $this->getValidStripeToken($request);

        

        
    }

    private function getValidStripeToken(Request $request)
    {
        $token = $request->input('stripeToken');

        if (is_null($token))
        {
            throw StripeException::noToken();
        }

        return $token;
    }

    /**
     * @return mixed
     */
    public function getPublishableKey()
    {
        return env('STRIPE_PUBLISHABLE_KEY');
    }

    /**
     * @return mixed
     */
    private function getSecretKey()
    {
        return env('STRIPE_SECRET_KEY');
    }
}