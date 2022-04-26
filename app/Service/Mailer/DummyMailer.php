<?php

namespace App\Service\Mailer;

use App\Contracts\Mail\MailInterface;

class DummyMailer implements MailInterface
{
	public function sendEmail($message, $to_email, $subject = null, $from = null, $reply_to = null)
	{
		$data = [
			'message'  => $message,
			'to_email' => $to_email,
			'subject'  => $subject,
			'from'     => $from,
			'reply_to' => $reply_to,
		];

		\Log::info(json_encode($data));

		return true;
	}
}
