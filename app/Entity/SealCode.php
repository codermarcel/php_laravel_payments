<?php

namespace App\Entity;

use App\BusinessLogic\Status\SealCodeStatus;
use App\Entity\EmailTemplate;
use App\Service\EntityService;

class SealCode extends BaseEntity
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'seal_codes';    

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

    public function email_template()
    {
    	return $this->belongsTo(EmailTemplate::class);
    }

    public function setStatus($status)
    {
        SealCodeStatus::ensureValidValue($status);

        $this->status = $status;

        $es = app(EntityService::class);
        $es->updateEntity($this);
    }
}
