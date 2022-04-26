<?php

namespace App\Entity;

use App\BusinessLogic\Status\SealCodeStatus;
use App\Entity\Product;
use App\Entity\SealCode;
use App\Repository\SealCodeRepository;
use App\Service\EntityService;

class EmailTemplate extends BaseEntity
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'email_templates';    

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
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [];

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

    public function product()
    {
    	return $this->belongsTo(Product::class);
    }

    public function seal_codes()
    {
        return $this->hasMany(SealCode::class);
    }

    public function getSingleCode()
    {
        $repo = app(SealCodeRepository::class);

        $code = $repo->findFirstUnusedByEmailTemplateId($this->id);

        $code_value = is_null($code) ? 'Your seller does not have any remaining codes, please contact him, email: ' . $this->product->user->email : 'null';

        if ( ! is_null($code))
        {
            $code_value = $code->code;
            $code->setStatus(SealCodeStatus::USED);
        }

        return $code_value;
    }
}
