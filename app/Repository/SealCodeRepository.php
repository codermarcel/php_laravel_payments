<?php

namespace App\Repository;

use App\BusinessLogic\Status\SealCodeStatus;
use App\Entity\SealCode;

class SealCodeRepository extends BaseRepository
{
	public function __construct()
	{
		parent::__construct(new SealCode);
	}

	public function findFirstUnusedByEmailTemplateId($input)
	{
		return $this->model
			->where('email_template_id', '=', $input)
			->where('status', '=', SealCodeStatus::DEFAULT)
			->first();
	}
}
