<?php

namespace App\Contracts\Purchase;

use App\Entity\User;
use Illuminate\Http\Request;

interface PurchaseProviderInterface
{
    /**
     * @param Request $request
     * @param int $price  price in smallest possible currency unit. (e.g pennies or cents for USD and EURO)
     * 
     * @return boolean true|false
     */
    public function purchase(Request $request, $price, User $user);
}