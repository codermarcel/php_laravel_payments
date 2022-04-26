<?php

namespace App\Repository;

use App\Entity\RecoveryCode;

class RecoveryCodeRepository extends BaseRepository
{
	public function __construct()
	{
		parent::__construct(new RecoveryCode);
	}
	
	public function findLatestByUserUuid($input)
	{
		return $this->model->where('user_uuid', '=', $input)->latest()->first();
	}

	public function getByToken($input)
	{
		return $this->model->where('token', '=', $input)->firstOrFail();
	}

	public function findByUserUuid($input)
	{
		return $this->model->where('user_uuid', '=', $input)->first();
	}

	public function findByToken($input)
	{
		return $this->model->where('token', '=', $input)->first();
	}
}
