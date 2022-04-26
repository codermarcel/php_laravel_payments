<?php

namespace App\Service\Mailer;

use App\Contracts\Mail\MailInterface;
use App\Entity\EmailTemplate;
use App\Entity\User;
use App\Exceptions\ServerException\NotImplementedException;

class MailService 
{
	private $mailer;

	public function __construct(MailInterface $mailer)
	{
		$this->mailer = $mailer;
	}

	public function sendRegisterEmail()
	{
		throw new NotImplementedException;
	}

	public function sendRecoveryEmail(User $user, $token)
	{
		list($message, $subject, $from) = $this->getRecoveryMailData($token);

		$this->mailer->sendEmail($message, $user->email, $subject, $from);
	}

	private function getRecoveryMailData($token)
	{
		$message = "It seems like you requested an account recovery, here is your token: $token";
		$subject = 'Account recovery.';
		$from    = 'our_awesome_service@cool.com';

		return [$message, $subject, $from];
	}

	/**
	 * Send acknowledgement email 
	 *
	 * Note : we don't care if the email send fails.
	 */
	public function sendAcknowledgementEmail($payment)
	{
		list($message, $subject, $from) = $this->getAcknowledgementEmailData();

		$this->mailer->sendEmail($message, $payment->email, $subject, $from);
	}

	/**
	 * Throw error when not successful.
	 */
	public function sendPurchaseConfirmationMail($payment)
	{
		$email_template = $payment->product->email_template;

		$message = $this->getMessageFromTemplate($email_template);
		$to_email = $payment->email;
		$subject  = $this->getPurchaseConfirmationSubject();

		if ( ! $this->mailer->sendEmail($message, $to_email, $subject))
		{
			$this->sendPurchaseConfirmedFailedEmail($payment);
		}
	}

	private function sendPurchaseConfirmedFailedEmail($payment)
	{
		$message = 'One of your confirmation emails could not be send.';
		$to_email = $payment->product->user->email;
		$subject = 'Confirmation email error';

		$this->mailer->sendEmail($message, $to_email, $subject);
	}

	/**
	 * Get the pattern that is used to be replaced by codes in email templates.
	 *
	 * Defaults to <code>
	 */
	private function getCodePattern()
	{
		return env('EMAIL_TEMPLATE_CODE_PATTERN', '<code>');
	}

	/**
	 * Replace the code pattern with an actual code (if the pattern exists)
	 *
	 * @return string  replaced template.
	 */
	private function getMessageFromTemplate(EmailTemplate $email_template)
	{
		$pattern  = $this->getCodePattern();
		$code     = $email_template->getSingleCode();
		$template = $email_template->email_content;

		return str_replace($pattern, $code, $template);
	}

	/**
	 * Get the purchase confirmation subject.
	 *
	 * Defaults to 'Purchase Confirmation Email'
	 */
	private function getPurchaseConfirmationSubject()
	{
		return env('EMAIL_PURCHASE_CONFIRMATION_SUBJECT', 'Purchase Confirmation Email');
	}

	/**
	 * Get some data for the acknowledgement email.
	 */
	private function getAcknowledgementEmailData()
	{
		$message = 'Thank you for your purchase!';
		$subject = 'We just want to let you know that we received your payment but are still waiting for the bitcoin network to confirm the payment.';
		$from    = 'our_awesome_service@cool.com';

		return [$message, $subject, $from];
	}
}
