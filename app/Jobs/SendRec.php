<?php

namespace App\Jobs;

use App\BusinessLogic\Status\RecoveryCodeStatus;
use App\Contracts\Jwt\Audience;
use App\Entity\RecoveryCode;
use App\Entity\User;
use App\Repository\RecoveryCodeRepository;
use App\Service\EntityService;
use App\Service\Jwt\JwtBuilder;
use App\Service\Log;
use App\Service\MailService;
use App\Service\Time\Time;

class SendRec extends Job
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
    public function handle(RecoveryCodeRepository $repo, MailService $mailer, EntityService $es) //Mailer $mailer
    {
        $this->checkMaxAttempts();

        $this->checkRecentlyCreated($repo);

        $token = $this->createCode($es);

		$mailer->sendRecoveryEmail($this->user, $token);
    }

    private function checkRecentlyCreated($repo)
    {
        $code = $repo->findByUserUuid($this->user->uuid);

        if ( ! is_null($code) && $this->wasRecentlyCreated($code->created_at))
        {
            $this->delete(); //we assume that the email was send correctly so we don't bother sending again.
            return;
        }
    }

    private function createCode($es)
    {
        $entity = new RecoveryCode;
        $entity->user_uuid = $this->user->uuid;

        $es->createEntity($entity); //throws error if it fails.
        $entity->setStatus(RecoveryCodeStatus::CREATED);

        return $entity->token;
    }

    private function checkMaxAttempts()
    {
        if ($this->attempts() >= $this->getMaxAttempts())
        {
            \Log::info('We reached the email max attempts limit, deleting.');
            $this->delete();
        }
    }

    private function wasRecentlyCreated($created_at)
    {
        return Time::isRecent($created_at, null, $this->getEmailResendTime());
    }

    /**
     * Get max attempts for sending the email.
     *
     * Defaults to 5 attempts.
     */
    private function getMaxAttempts()
    {
        return 5;
    }

    /**
     * Get how long we should wait before sending a new recovery email (to prevent spam and cost.)
     *
     * Defaults to 30 minutes.
     */
    private function getEmailResendTime()
    {
       $minutes = env('EMAIL_RESENT_TIME_LIMIT_MINUTES', 30);

       return $minutes * 60;
    }
}
