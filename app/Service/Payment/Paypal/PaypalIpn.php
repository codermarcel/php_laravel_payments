<?php 

namespace App\Service\Payment\Paypal;

use App\Exceptions\ServerException\PaypalException;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;

class PaypalIpn
{
	/**
     * Status from paypal
     */
    const NOTIFY_VERIFIED = 'VERIFIED';
    const NOTIFY_INVALID = 'INVALID';

    /**
     * Send this to notify paypal to validate the request.
     */
    const CMD_NOTIFY_VALIDATE = '_notify-validate';

    /**
     * Paypal endpoints.
     */
    const PAYPAL_ENDPOINT         = 'https://www.paypal.com/cgi-bin/webscr';
    const PAYPAL_SANDBOX_ENDPOINT = 'https://www.sandbox.paypal.com/cgi-bin/webscr';

    /**
     * The request header.
     */
    const REQUEST_HEADER = ['Content-Type' => 'application/x-www-form-urlencoded'];

    /**
     * vars.
     */
	private $sandbox = false;
	private $client;

	/**
	 * Constructor.
	 */
	public function __construct(ClientInterface $client, $sandbox = false)
	{
		$this->sandbox = $sandbox;
		$this->client = $client;
	}

	/**
	 * Set the mode (sandbox or not)
	 */
	public function setSandbox($sandbox = true)
	{
		$this->sandbox = $sandbox;
	}

    public function isVerified(array $all)
    {
        return $this->notifyValidate($all) === self::NOTIFY_VERIFIED;
    }

    /**
     * @param array $fields
     *
     * @return string
     */
    private function notifyValidate(array $fields)
    {
        $fields['cmd'] = self::CMD_NOTIFY_VALIDATE;

        $request = new Request('POST', $this->getIpnEndpoint(), self::REQUEST_HEADER, http_build_query($fields));
        $response = $this->client->send($request);

        $code = $response->getStatusCode();

        if (false == ($code >= 200 && $code < 300)) {
            throw PaypalException::notOk($code);
        }

        $result = $response->getBody()->getContents();

        return self::NOTIFY_VERIFIED === $result ? self::NOTIFY_VERIFIED : self::NOTIFY_INVALID;
    }

    /**
     * Get the paypal endpoint
     */
    private function getIpnEndpoint()
    {
    	return $this->sandbox ? self::PAYPAL_SANDBOX_ENDPOINT : self::PAYPAL_ENDPOINT;
    }
}