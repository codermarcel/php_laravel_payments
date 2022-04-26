<?php

namespace App\BusinessLogic\Money;

use App\BusinessLogic\Money\USD;

trait PaymentUsdTrait
{
    public function setPriceUsdAttribute(USD $money)
    {
        $this->attributes['price_usd'] = $money->toPennies();;
    }

    /**
     * Convert pennies to USD.
     */
    public function getPriceUsdAttribute($pennies)
    {
        return USD::fromPennies($pennies);
    }
}
