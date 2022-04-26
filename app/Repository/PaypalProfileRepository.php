<?php

namespace App\Repository;

use App\Entity\PaypalProfile;

class PaypalProfileRepository extends BaseRepository
{
	public function __construct()
	{
		parent::__construct(new PaypalProfile);
	}
}