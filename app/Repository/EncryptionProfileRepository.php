<?php

namespace App\Repository;

use App\Entity\EncryptionProfile;

class EncryptionProfileRepository extends BaseRepository
{
	public function __construct()
	{
		parent::__construct(new EncryptionProfile);
	}
}