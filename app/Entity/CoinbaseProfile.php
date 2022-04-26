<?php

namespace App\Entity;

use App\BusinessLogic\Profile\ProfileTrait;

class CoinbaseProfile extends BaseEntity
{
    use ProfileTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'profile_coinbase';    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['api_key', 'api_secret', 'enabled'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = []; //normally we should hide the api_key and api_secret, but we assume that the api keys have no critical permissions.

    /**
     * Those validation rules are complicated to explain and only work on the front end in a specific way (ask me)
     */
    public function getBaseRule()
    {
        return [
            'enabled'    => 'boolean|required_with:api_key,api_secret', //make sure that they cant enable the profile without setting the api_key and api_secret
            'api_key'    => 'size:16',
            'api_secret' => 'size:32',
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
