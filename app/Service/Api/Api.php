<?php

namespace App\Service\Api;

use App\BusinessLogic\Money\BTC;
use App\Entity\Payment;
use App\Service\Request\Limiter;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class Api extends ApiResponse
{

    public static function paymentResponse(Payment $payment, $additional = null, $request = null)
    {
        $product = $payment->product;
        $user    = $product->user;
        
        $data = [
            'transaction_id'    => $payment->transaction_id,
            'seller_username'   => $user->username,
            'seller_id'         => $user->id,
            'product_id'        => $product->id,
            'usd_price'         => $payment->price_usd->toDollars(),
            'usd_price_pennies' => $payment->price_usd->toPennies(),
        ];

        foreach ($additional as $key => $value) 
        {
           $data[$key] = $value;
        }

        return static::ok($request, $data);
    }


    /**
     * Named constructors
     */
    public static function ok($request = null, $data = [])
    {
        $api = new static($request);

        foreach($data as $key => $value)
        {
            $api->set($key, $value);
        }

        return $api->build();
    }

    /**
     * Named constructors
     */
    public static function fail($request = null, $code = 500)
    {
        $api = new static($request);
        $api->setCode($code);

        return $api->build();
    }

    public static function error(Exception $e, Request $request = null)
    {
        list($code, $message) = (new ExceptionConverter)->convertException($e);

        $api = new static($request);
        $api->setCode($code);
        $api->setMessage($message);
        
        return $api->build();
    }

    public static function toBitcoinResponse($btc_address, BTC $btc, $transaction_id, $request = null)
    {
        $btc_amount = $btc->toBtc();

        $api = new static($request);
        $api->set('transaction_id', $transaction_id);
        $api->set('btc_address', $btc_address);
        $api->set('btc_amount', $btc_amount);
        $api->setMessage("Please send $btc_amount btc in total to $btc_address to complete the purchase.");

        return $api->build();
    }
    
    public static function fromSearch($result, $request, $name = 'result')
    {
        $api = new static($request);

        $api->setRequestLimits(true);

        if ($result instanceof LengthAwarePaginator)
        {
            return $api->fromAdvanced($result, $name);
        }

        return $api->fromSimple($result, $name);
    }

    /**
     * Search stuff
     */
    public function fromAdvanced(LengthAwarePaginator $result, $name)
    {
        $data = $result->toArray();

        $this->set('total', $data['total']);
        $this->set('count', $data['per_page']);
        $this->set('from', $data['from']);
        $this->set('to', $data['to']);
        $this->set('next_page_url', $data['next_page_url']);
        $this->set('prev_page_url', $data['prev_page_url']);
        $this->set($name, $data['data']);

        return $this->build();
    }

    public function fromSimple($result, $name)
    {
        list($total, $result) = $result;

        $this->set('total', $total);
        $this->set('count', count($result));
        $this->set($name, $result);

        return $this->build();
    }

    /**
     * Setter
     */
    public function setToken($input)
    {
        return $this->set('token', $input);
    }

    public function setMessage($message = null)
    {
        if ( ! empty($message))
        {
            $this->set('message', $message);
        }

        return $this;
    }

    public function cachable($cachable = true)
    {
        return $this->setHeader('Cachable', $cachable);
    }

    /**
     * Request Limits
     */
    public function setRequestLimits($asHeader = false)
    {
        if ($this->isAuthenticated())
        {
            $limiter = new Limiter($this->request);

            $limit   = $limiter->getLimit();
            $current = $limiter->getCurrentCount();
            $remaining = $limiter->getLimit() - $limiter->getCurrentCount();



            // $data = [
            //     'limit'     => $limit,
            //     'current'   => $current,
            //     'remaining' => $remaining,
            // ];

            // $this->set('request', $data, $asHeader);

            $this->set('requests_limit', $limit, $asHeader);
            $this->set('requests_current', $current, $asHeader);
            $this->set('requests_remaining', $remaining, $asHeader);
        }

        return $this;
    }

    private function isAuthenticated()
    {
        try {
            $user = $this->request->user();
            return true;
        } catch (\Exception $e) {
        }

        return false;
    }
}