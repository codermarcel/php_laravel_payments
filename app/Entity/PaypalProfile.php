<?php

namespace App\Entity;

use App\BusinessLogic\Profile\ProfileTrait;

class PaypalProfile extends BaseEntity
{
    use ProfileTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'profile_paypal';    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['paypal_email', 'enabled'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Those validation rules are complicated to explain and only work on the front end in a specific way (ask me)
     */
    public function getBaseRule()
    {
        return [
            'enabled'      => 'boolean|required_with:paypal_email', //make sure they cant set enabled without setting a paypal email address.
            'paypal_email' => 'email|min:8|max:99',
        ];
    }

    /**
     * getCreateRule
     */
    public function getCreateRule()
    {
        return [];
    }

    /**
     * getUpdateRule
     */
    public function getUpdateRule($id = null)
    {
        $id = $id ?: $this->id;

        return [];
    }
}
