<?php

namespace App\Contracts\Payment\Bitcoin;

use App\Entity\Product;

interface TransactionBuilder
{
	/**
	 * @return App\Entity\Payment
	 */
	public function make(Product $product, $email);
}
