<?php

namespace App\Service\Purchase;

use App\Contracts\Purchase\PurchaseProviderInterface;
use Illuminate\Http\Request;

class PaypalPurchase implements PurchaseProviderInterface
{
    public function purchase(Request $request, $price)
    {
        
    }
}