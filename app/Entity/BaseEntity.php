<?php

namespace App\Entity;

use App\BusinessLogic\Model\UuidAsKey;
use App\Exceptions\ClientException\ValidationException;
use App\Service\EntityService;
use App\Service\Time\Time;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

abstract class BaseEntity extends Model
{
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
     * Construct
     */
    private $validator;

    /**
     * Constructor.
     */
  	public function __construct(array $attributes = array(), $validator = null)
  	{
  	    parent::__construct($attributes);

  		$this->validator = $validator ?: app('validator');

        $this->attributes['id'] = Uuid::uuid4();
  	}

    /**
     * Return the primary key name.
     */
    public static function keyName() 
    {
        return (new static)->getKeyName();
    }

    /**
     * Return the table name.
     */
    public static function tableName() 
    {
        return (new static)->getTable();
    }

  	/**
  	 * Boot validaton rules
  	 */
    protected static function boot()
    {
        parent::boot();

        static::creating(function($model)
        {
            if($model->autoValidate)
            {
                return $model->validateCreate();
            }
        });

        static::updating(function($model)
        {
            if($model->autoValidate)
            {
                return $model->validateUpdate();
            }
        });
    }

    /**
     * Ensure saving / updating works and throw an exception if it doesnt.
     */
    public function ensureSaved()
    {
        $es = new EntityService;
        $es->updateOrCreateEntity($this);

        return $this;
    }

    /**
     * Auto Validation
     * @var boolean
     */
    protected $autoValidate = true;

    /**
     * Set
     */
    public function setAutoValidate($boolean = true)
    {
        $this->autoValidate = $boolean;
    }

    /**
     * Get
     */
    public function getAutoValidate()
    {
        return $this->autoValidate;
    }

    /**
     * Create rule
     */
    public function validateCreate()
    {
        $rules = $this->makeRules($this->getCreateRule());

        $v = $this->validator->make($this->attributes, $rules);

        if ($v->fails())
        {
            throw new ValidationException($v->errors()->first());
        }
    }

    /**
     * Update rule
     */
    public function validateUpdate()
    {
        $rules = $this->makeRules($this->getUpdateRule());

        $v = $this->validator->make($this->attributes, $rules);

        if ($v->fails())
        {
            throw new ValidationException($v->errors()->first());
        }
    }

    private function makeRules(array $rules)
    {
        $baseRule = [];

        if (method_exists($this, 'getBaseRule'))
        {
            $baseRule = $this->getBaseRule();
        }

        return array_merge($baseRule, $rules);
    }

    /**
     * The child class should override those methods.
     */
    abstract protected function getUpdateRule($id = null);
    abstract protected function getCreateRule();
}
