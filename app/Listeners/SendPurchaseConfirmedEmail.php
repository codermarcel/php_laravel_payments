<?php

namespace App\Listeners;

use App\Events\PurchaseConfirmedEvent;
use App\Service\Mailer\MailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPurchaseConfirmedEmail implements ShouldQueue
{
	private $mailer;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(MailService $mailer)
    {
		$this->mailer = $mailer;
    }

    /**
     * Handle the event.
     *
     * @param  ExampleEvent  $event
     * @return void
     */
    public function handle(PurchaseConfirmedEvent $event)
    {
        $this->mailer->sendPurchaseConfirmationMail($event->payment);
    }
}
