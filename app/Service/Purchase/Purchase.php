<?php

namespace App\Service\Purchase;

use App\Contracts\Purchase\PurchaseProviderInterface;
use App\Entity\User;
use App\Exceptions\ClientException\PurchaseException;
use Illuminate\Http\Request;

class Purchase
{
    private $provider;

    public function __construct(PurchaseProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @param Request $request
     * @param int $purchase_id
     * @return bool
     * @throws PurchaseException
     */
    public function purchase(Request $request, $purchase_id, User $user)
    {
        $price = $purchase_id == 1 ? 999 : 2999;
        
        if ( ! $this->provider->purchase($request,$price))
        {
            throw PurchaseException::cantPurchase();
        }
        
        return $this->provider->purchase($request, $price);
    }
}