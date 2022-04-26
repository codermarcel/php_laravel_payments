<?php

namespace App\BusinessLogic\Model;

use Ramsey\Uuid\Uuid;

trait UuidAsKey
{
    /**
     * Boot the Uuid trait for the model.
     *
     * @return void
     */
    public static function bootUuidAsKey()
    {
        static::creating(function ($model) {
            $model->incrementing = false;
            $model->{$model->getKeyName()} = (string)Uuid::uuid4();
        });
    }
}