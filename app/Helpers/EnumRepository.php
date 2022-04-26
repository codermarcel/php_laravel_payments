<?php

namespace App\Helpers;

use App\Exceptions\ServerException\EnumException;

/**
 * Class EnumRepository
 * Helper methods to find and get the constant by its key or value.
 * 
 * @package App\Helpers
 */
trait EnumRepository
{
    /**
     * @return array  return the enum constants.
     */
   public static function all()
   {
       return static::toArray();
   }

    /**
     * @param $key
     * @return null|static
     */
    public static function findByKey($key)
    {
        if (isset(static::all()[$key]))
        {
            return static::fromKey($key);
        }
        
        return null;
    }

    /**
     * @param $input
     * @return null|static
     */
    public static function findByValue($input)
    {   
        foreach(static::all() as $key => $value)
        {
            if ($value == $input)
            {
                return static::fromKey($key);
            }
        }
        
        return null;
    }

    /**
     * @param $key
     * @return null|static
     */
    public static function getByKey($key)
    {
        $result = self::findByKey($key);

        if ($result === null)
        {
            throw EnumException::cantFinddByKey();
        }

        return $result;
    }

    /**
     * @param $input
     * @return null|static
     */
    public static function getByValue($input)
    {
        $result = self::findByValue($input);

        if ($result === null)
        {
            throw EnumException::cantFinddByValue();
        }

        return $result;
    }
}