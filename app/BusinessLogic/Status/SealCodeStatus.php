<?php

namespace App\BusinessLogic\Status;

use App\Exceptions\ServerException\EnumException;
use App\Helpers\AbstractEnum;

class SealCodeStatus extends AbstractEnum
{
	const DEFAULT   = 0;
	const USED      = 1;
}