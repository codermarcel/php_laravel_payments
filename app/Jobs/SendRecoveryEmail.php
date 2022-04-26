<?php

namespace App\Jobs;

use App\Entity\User;
use App\Jobs\NotQueuedJob;
use App\Service\Mailer\MailService;
use App\Service\Time\Time;
use App\Service\Token\TokenManager;

class SendRecoveryEmail extends Job
{
	private $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
		$this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(TokenManager $tokenManager, MailService $mailService) //Mailer $mailer
    {
        $this->checkMaxAttempts();

        if ( ! is_null($tokenManager->findLatestValidToken($this->user)))
        {
            return; //dont resend the recovery email, wait until the last expires (30-60 minutes depending on settings) before re-sending.
        }

        $token = $tokenManager->createToken($this->user);

        $mailService->sendRecoveryEmail($this->user, $token->token);
    }

    private function checkMaxAttempts()
    {
        if ($this->attempts() >= $this->getMaxAttempts())
        {
            \Log::info('We reached the max attempts for recovering, deleting.');
            $this->delete();
        }
    }

    /**
     * Get max attempts for sending the email.
     *
     * Defaults to 5 attempts.
     */
    private function getMaxAttempts()
    {
        return env('RECOVERY_EMAIL_RESEND_MAX_ATTEMPTS', 5);
    }
}
