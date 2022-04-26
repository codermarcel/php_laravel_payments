<?php

namespace App\Entity;

use App\BusinessLogic\Crypto\OneWayDecryptableTrait;
use App\BusinessLogic\Money\ProductUsdTrait;
use App\BusinessLogic\Money\USD;
use App\BusinessLogic\Product\Status;
use App\Entity\EmailTemplate;
use App\Entity\User;
use App\Service\Crypto\Aes\AesService;
use App\Service\Crypto\Rsa\RsaService;

class Product extends BaseEntity
{
    use ProductUsdTrait, OneWayDecryptableTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';    

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];

    /**
     * Crypto provider
     */
    private $cryptoProvider;

    /**
     * The attributes that should be encrypted.
     *
     * @var array
     */
    protected $encryptable = ['name', 'description', 'price', 'created_at', 'updated_at'];
    
    private function __construct(User $user, array $attributes, $validator = null)
    {
        $this->setCryptoProvider(AesService::fromUser($user));
        
        parent::__construct($attributes, $validator);
    }

    /**
     * Load product with crypto provider via the symmetric encryption $key
     *
     * @param $key
     */
    public function fromKey($key)
    {
        
    }


    public static function fromUser(User $user, array $attributes = [], $validator = null)
    {
        return static($user, $attributes, $validator);
    }
    
    public function generateKey()
    {
        
    }
    
    public function changeKey()
    {
        
    }

    /**
     * Set cryptoprovider for decryption.
     */
    public function setCryptoProvider(AesService $cryptoProvider)
    {
        $this->cryptoProvider = $cryptoProvider;
    }

    /**
     * @param Status $status
     */
    public function setStatusAttribute(Status $status)
    {
        $this->attributes['status'] = $status;
    }

    public function getStatusAttribute($value)
    {
        return new Status($value);
    }

    /**
     * Get base rule.
     */
    protected function getBaseRule()
    {
        return [
            'enabled'     => 'boolean|required_with:name,price', //make sure they cant change enabled (true|false) without providing a name and price.
            'price'       => 'integer|min:10|max:10000',  //10 pennies and 10.000 pennies are min:max (0.1 usd - 100 usd)

            //rsa encrypted encryption key.
            'encrypted_key' => 'required|min:50|max:600',

            //Encrypted data.
            'name'        => 'required|min:4|max:600', 
            'description' => 'min:10|max:600',
        ];
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

    /**
     * Relationships.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function email_template()
    {
        return $this->hasOne(EmailTemplate::class);
    }

    public function isAnonymous()
    {
        return $this->anonymous;
    }
}
