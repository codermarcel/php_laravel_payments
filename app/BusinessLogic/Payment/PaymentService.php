<?php

namespace App\BusinessLogic\Payment;

use App\Exceptions\ServerException\EnumException;
use App\Helpers\AbstractEnum;

class PaymentService extends AbstractEnum
{
    const DEFAULT  = 'default';
    const PAYPAL   = 'paypal';
    const COINBASE = 'coinbase';
    const STRIPE   = 'stripe';
}