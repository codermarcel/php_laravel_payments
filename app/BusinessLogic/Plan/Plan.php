<?php

namespace App\BusinessLogic\Plan;

use App\Helpers\AbstractEnum;

class Plan extends AbstractEnum
{
    const MONTH      = 1;
    const QUARTER    = 2;
    const SEMIANNUAL = 3;
    const ANNUAL     = 4;
}