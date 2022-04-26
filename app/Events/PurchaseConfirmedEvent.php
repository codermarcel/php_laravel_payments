<?php

namespace App\Events;

use App\Entity\Payment;

class PurchaseConfirmedEvent extends Event
{
	public $payment;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }
}
