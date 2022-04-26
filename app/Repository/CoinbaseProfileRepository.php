<?php

namespace App\Repository;

use App\Entity\CoinbaseProfile;

class CoinbaseProfileRepository extends BaseRepository
{
	public function __construct()
	{
		parent::__construct(new CoinbaseProfile);
	}
}