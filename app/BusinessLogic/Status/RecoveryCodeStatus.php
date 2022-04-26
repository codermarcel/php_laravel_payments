<?php

namespace App\BusinessLogic\Status;

use App\Exceptions\ServerException\EnumException;
use App\Helpers\AbstractEnum;

class RecoveryCodeStatus extends AbstractEnum
{
	const DEFAULT   = 0;
	const CREATED   = 1;
	const COMPLETED = 2;
}