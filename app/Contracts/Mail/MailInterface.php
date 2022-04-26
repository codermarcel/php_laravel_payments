<?php

namespace App\Contracts\Mail;

interface MailInterface
{
	public function sendEmail($message, $to_email, $subject = null, $from = null, $reply_to = null);
}
