<?php

namespace App\Entity;

use App\BusinessLogic\User\UserOwnerTrait;
use App\BusinessLogic\User\UserPasswordTrait;
use App\BusinessLogic\User\UserPermissionTrait;
use App\Exceptions\ServerException;
use Defuse\Crypto\Key;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Ramsey\Uuid\Uuid;

class User extends Authenticatable
{
    use UserPermissionTrait,
        UserPasswordTrait,
        UserOwnerTrait;

    /**
     * The unlocked master key var
     * Store it as a var so it doesnt persist to the database.
     * @var null
     */
    private $unlocked_master_key = null;
    
    /**
     * Indicates if the model has update and creation timestamps.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The storage format of the model's date columns.
     *
     * Unix format.
     *
     * @var string
     */
    public $dateFormat = 'U';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'salt', 'email', 'remember_token'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'username', 'password'];

    /**
     * User constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->attributes['id'] = Uuid::uuid4();
    }

    public function isConfirmed()
    {
        return $this->email_confirmed;
    }

    /**
     * Get the base rule for all rules.
     *
     * we hash this anyway, so no point in making this bigger than 1. (we dont validate input, we validate the model !!)
     * @see App\BusinessLogic\User\UserPasswordTrait
     */
    public function getBaseRule()
    {
        return [
            'password'   => 'required|min:1',
        ];
    }

    /**
     * Create rule
     */
    protected function getCreateRule()
    {
        return [
            'email'     => 'required|min:8|max:99|email|unique:users',
            'username'  => 'required|min:4|max:99|unique:users',
        ];
    }

    /**
     * Update rule.
     */
    public function getUpdateRule($id = null)
    {
        $id = $id ?: $this->id;

        return [
            'email'     => 'min:8|max:99|email|unique:users,email,' . $id,
            'username'  => 'min:4|max:99|unique:users,username,' . $id,
        ];
    }

    public function getIdentifier()
    {
        return $this->id;
    }

    /**
     * @return null
     * @throws ServerException
     */
    public function getUnlockedMasterKey()
    {
        if ($this->unlocked_master_key === null)
        {
            throw new ServerException('The unlocked master key has not been set.');
        }

        return $this->unlocked_master_key;
    }

    /**
     * @param Key $key
     */
    public function setUnlockedMasterKey(Key $key)
    {
        $this->unlocked_master_key = $key;
    }

    /**
     * Convenient method to get user permissions.
     *
     * @return null|Illuminate\Database\Eloquent\Collection
     */
    public function getPermissions(Cache $cache = null)
    {
        $cache = $cache ?: app(Cache::class);
        $minutes = 10;
        $role = $this->role;

        return $cache->remember('user.permissions.' . $this->id, $minutes, function() use($role) {
            $notOk = empty($role) ?: is_null($role->group); //use is_null instead of empty.

            if ($notOk)
            {
                return null;
            }

            return $role->group->permissions->toArray();
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function api_keys()
    {
        return $this->hasMany(ApiKey::class);
    }

    public function recovery_code()
    {
        return $this->hasOne(RecoveryCode::class);
    }

    public function coinbase_profile()
    {
        return $this->hasOne(CoinbaseProfile::class);
    }

    public function paypal_profile()
    {
        return $this->hasOne(PaypalProfile::class);
    }

    public function encryption_profile()
    {
        return $this->hasOne(EncryptionProfile::class);
    }
}
