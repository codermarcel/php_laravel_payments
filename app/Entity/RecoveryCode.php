<?php

namespace App\Entity;

use App\BusinessLogic\Status\RecoveryCodeStatus;
use App\Entity\User;
use App\Service\RandomService;

class RecoveryCode extends BaseEntity
{
	/**
     * Constructor
     */
    public function __construct(array $attributes = array(), RandomService $random = null)
    {
        parent::__construct($attributes);

        $random = $random ?: app(RandomService::class);
        
        $this->attributes['token'] = $random->generateToken();
    }

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'recovery_codes';    

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
    protected $fillable = [];

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

    public function getStatus()
    {
        $repo = app(RecoveryCodeStatusRepository::class);

        return $repo->getLatestByRecoveryCodeId($this->id) ?: RecoveryCodeStatus::DEFAULT;
    }

    public function setStatus($input)
    {
        RecoveryCodeStatus::ensureValidValue($input);
        
        $es = app(EntityService::class);
        $es->updateEntity($this, ['status' => $input]);
    }
}
