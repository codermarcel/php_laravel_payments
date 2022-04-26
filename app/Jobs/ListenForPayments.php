<?php

namespace App\Jobs;

use App\BusinessLogic\Money\BTC;
use App\BusinessLogic\Status\PaymentStatus;
use App\Contracts\Payment\Bitcoin\TransactionSearcher;
use App\Exceptions\ClientException\CoinBaseException;
use App\Repository\PaymentRepository;
use App\Service\MailService;
use App\Service\Payment\Coinbase\CoinbaseTransactionSearcher;
use Coinbase\Wallet\Enum\CurrencyCode;
use Coinbase\Wallet\Resource\Account;
use Coinbase\Wallet\Resource\Transaction;
use Coinbase\Wallet\Value\Money;
use GuzzleHttp\Client;

class ListenForPayments extends Job
{
    private $doDelete = false;
    private $transaction_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($transaction_id)
    {
        $this->transaction_id = $transaction_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(PaymentRepository $payments, TransactionSearcher $searcher, MailService $mailer)
    {
        $sep = '------------------------------------------------';
        \Log::info(PHP_EOL . 'This is attempt number : ' . $this->attempts() . PHP_EOL . $sep);

        $payment = $payments->getByTransactionId($this->transaction_id);

        $this->checkAttempts();

        if ($searcher->hasConfirmedPayment($payment) && $payment->status !== PaymentStatus::COMPLETE)
        {
            \Log::info('sending out confirm email then payout and delete');
            $mailer->sendPurchaseConfirmationMail($payment);
            $payment->setStatus(PaymentStatus::COMPLETE);
            $this->delete();
            return;
        }

        if ($searcher->hasUnconfirmedPayment($payment) && $payment->status === PaymentStatus::NONE)
        {
            \Log::info('send acknowledgement email');
            $mailer->sendAcknowledgementEmail($payment);
            $payment->setStatus(PaymentStatus::ACKNOWLEDGED);
        }
        
        \Log::info(PHP_EOL . $sep . PHP_EOL);
        $this->keepAlive();
    }

    private function keepAlive()
    {
        if ($this->doDelete !== true)
        {
            $this->release($this->getCheckInterval());
        }
    }

    /**
     * Make sure we dont exceed the map attempts.
     *
     * @return void
     */
    private function checkAttempts()
    {
        if ($this->attempts() >= $this->getMaxAttempts())
        {
            \Log::info('max attempts reached, delete!');
            $this->doDelete = true;
            $this->delete();
        }
    }

    /**
     * Get the check interval in minutes.
     * 
     * @return int
     */
    private function getCheckInterval()
    {
        $minutes = env('PAYMENT_CHECK_INTERVAL_MINUTES', 5);

        return $minutes * 60;
    }

    /**
     * Get the maximum amount of attempts the listener should execute.
     *
     * Defaults to the amount required for the entire day (calculated by the check interval)
     * Example : 1 Day has 86400 seconds, check interval is 300 seconds,  86400 / 300 = 288
     * so we would check 288 times (which is one day)
     * 
     * @return int
     */
    private function getMaxAttempts()
    {
        $secondsPerDay = 60 * 60 * 24;
        $oneDay = $secondsPerDay / $this->getCheckInterval();

        return env('PAYMENT_CHECK_MAX_ATTEMPTS', $oneDay);
    }
}
