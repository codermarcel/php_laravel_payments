<?php

/**
 * @link    http://github.com/myclabs/php-enum
 * @license http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 *
 * @modified
 */
namespace App\Helpers;

use App\Exceptions\ServerException\EnumException;

trait EnumTrait
{
    /**
     * Enum value
     *
     * @var mixed
     */
    protected $value;

    /**
     * Store existing constants in a static cache per object.
     *
     * @var array
     */
    protected static $cache = array(); //NOTE : php-pm -> this might cause problems.

    /**
     * Creates a new value of some type
     *
     * @param mixed $value
     *
     * @throws \UnexpectedValueException if incompatible type is given.
     */
    public function __construct($value)
    {
        if ( ! $this->isValidValue($value)) {
            throw new \UnexpectedValueException("Value '$value' is not part of the enum " . get_called_class());
        }

        $this->value = $value;
    }

    /**
     * @param $key
     * @return static
     */
    public static function fromKey($key)
    {
        return new static(static::toArray()[$key]);
    }

    /**
     * @param $value
     * @return static
     */
    public static function fromValue($value)
    {
        return new static($value);
    }

    /**
     * Display the enum value as string.
     */
    public static function asString($value)
    {
        static::ensureValidValue($value);

        try {
            return (new static($value))->__toString();
        } catch (\Exception $e){
            return 'N/A';
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->value;
    }

    /**
     * Returns all possible values as an array
     *
     * @return array Constant name in key, constant value in value
     */
    public static function toArray()
    {
        $class = get_called_class();

        if ( ! array_key_exists($class, static::$cache)) 
        {
            $reflection            = new \ReflectionClass($class);
            static::$cache[$class] = $reflection->getConstants();
        }

        return static::$cache[$class];
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Ensure that the input value is a valid class constant.
     *
     * @throws EnumException
     */
    public static function ensureValidValue($input)
    {
        if ( ! static::isValidValue($input))
        {
            throw EnumException::badInput($input);
        }
    }

    /**
     * Check if is valid enum value
     *
     * @param $value
     *
     * @return bool
     */
    public static function isValidValue($value)
    {
        return in_array($value, static::toArray(), true);
    }

    /**
     * Returns a value when called statically like so: MyEnum::SOME_VALUE() given SOME_VALUE is a class constant
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return static
     * @throws \BadMethodCallException
     */
    public static function __callStatic($name, $arguments)
    {
        $array = static::toArray();

        if (isset($array[$name])) {
            return new static($array[$name]);
        }

        throw new \BadMethodCallException("No static method or enum constant '$name' in class " . get_called_class());
    }
}