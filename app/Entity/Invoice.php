<?php

namespace App\Entity;

use App\BusinessLogic\Crypto\OneWayEncryptableTrait;
use App\BusinessLogic\Money\PaymentUsdTrait;
use App\BusinessLogic\Money\USD;
use App\BusinessLogic\Status\PaymentStatus;
use App\Contracts\Money\CurrencyInterface;
use App\Entity\Product;
use App\Service\Crypto\Rsa\RsaService;
use App\Service\EntityService;

class Invoice extends BaseEntity
{
    use OneWayEncryptableTrait;

    /**
     * Indicates if the model has update and creation timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Crypto provider
     */
    private $cryptoProvider;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'invoices';    

    /**
     * The attributes that should be encrypted.
     *
     * @var array
     */
    protected $encryptable = ['transaction_id', 'service_id', 'payment_service', 'pay_to_address', 'customer_email', 'price_usd', 'price_other', 'created_at', 'updated_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['transaction_id', 'product_id', 'service_id', 'payment_service', 'pay_to_address', 'customer_email', 'price_usd', 'price_other'];


    /**
     * Constructor
     */
    public function __construct(array $attributes = array(), RsaService $cryptoProvider)
    {
        $this->cryptoProvider = $cryptoProvider;

        parent::__construct($attributes);
    }

    /**
     * getCreateRule
     */
    protected function getCreateRule()
    {
        return [];
    }

    /**
     * getUpdateRule
     */
    protected function getUpdateRule($id = null)
    {
        $id = $id ?: $this->id;

        return [];
    }
}
