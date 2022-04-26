<?php

namespace App\Entity;

use App\BusinessLogic\Money\PaymentUsdTrait;
use App\BusinessLogic\Status\PaymentStatus;
use App\Entity\Product;
use App\Service\EntityService;

class Payment extends BaseEntity
{
    use PaymentUsdTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payments';    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['service_id'];

    /**
     * The attributes shown in the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['updated_at', 'created_at'];

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

    /**
     * Relationships.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function setStatus($status)
    {
        PaymentStatus::ensureValidValue($status);

        $this->status = $status;

        $es = app(EntityService::class);
        $es->updateEntity($this);
    }
}
