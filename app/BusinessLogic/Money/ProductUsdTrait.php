<?php

namespace App\BusinessLogic\Money;

use App\BusinessLogic\Money\USD;

trait ProductUsdTrait
{
    public function setPriceAttribute(USD $usd)
    {
        $this->attributes['price'] = $usd->toPennies();
    }

    /**
     * Convert pennies to USD.
     */
    public function getPriceAttribute($pennies)
    {
        return USD::fromPennies($pennies);
    }
}
