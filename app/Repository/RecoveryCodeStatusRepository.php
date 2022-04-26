<?php

namespace App\Repository;

use App\Entity\RecoveryCodeStatus;

class RecoveryCodeStatusRepository extends BaseRepository
{
	public function __construct()
	{
		parent::__construct(new RecoveryCodeStatus);
	}

	public function findLatestByRecoveryCodeId($id)
	{
		return $this->model->where('recovery_code_id', $id)->latest()->first();
	}
}
