<?php

namespace App\Entity;

use App\BusinessLogic\Profile\ProfileTrait;
use App\Entity\User;
use App\Service\Crypto\Aes\AesService;

class EncryptionProfile extends BaseEntity
{
    use ProfileTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'profile_encryption';    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['public_key'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $visible = ['public_key'];

    /**
     *
     */
    public function getBaseRule()
    {
        return [
            'public_key' => 'required|min:300', //assume a key size of at least 2048 bits.
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getEncryptionKeyAttribute($value)
    {
        if (is_null($value))
        {
            $crypto = new AesService(null);
            $value = $crypto->generateEncryptionKey();
            $this->encryption_key = $value;
            $this->ensureSaved();
        }

        return $value;
    }
}
