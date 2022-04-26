<?php

namespace App\BusinessLogic\Status;

use App\Exceptions\ServerException\EnumException;
use App\Helpers\AbstractEnum;

class PaymentStatus extends AbstractEnum
{
	const DEFAULT = 0;
	const PENDING = 1;
	//const DONE  = 2; //we have no done status because payments are transfered to invoices if they are done.
	const ERROR   = 3;

	/**
	 * Readable string representation of every status.
	 */
	public static $readable = [
		self::DEFAULT => 'pending', //it kinda is pending as well.
		self::PENDING => 'pending',
		self::ERROR   => 'error',
	];
}