<?php

namespace App\Listeners;

use App\Events\PurchaseConfirmedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogPurchaseConfirmed implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ExampleEvent  $event
     * @return void
     */
    public function handle(PurchaseConfirmedEvent $event)
    {
        \Log::info(sprintf(
            'User with username (%s) has made a sell, transaction_id (%s)',
            $event->payment->product->user->username,
            $event->payment->transaction_id
        ));
    }
}
