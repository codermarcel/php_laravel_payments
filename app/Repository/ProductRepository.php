<?php

namespace App\Repository;

use App\Entity\Product;

class ProductRepository extends BaseRepository
{
	public function __construct()
	{
		parent::__construct(new Product);
	}
	
	public function getProductsForUser($user)
	{
		return $this->model->where('user_id', '=', $user->id);
	}
}
