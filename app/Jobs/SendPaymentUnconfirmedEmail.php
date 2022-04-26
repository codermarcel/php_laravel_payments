<?php

namespace App\Jobs;

use App\Service\MailService;

class SendPaymentUnconfirmedEmail extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(MailService $mailer)
    {
        //
    }
}
