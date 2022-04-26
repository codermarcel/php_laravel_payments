<?php

namespace App\Helpers;

/**
 * Base Enum class
 */
abstract class AbstractEnum
{
    use EnumTrait, EnumRepository;
}