<?php

namespace App\Contracts\Money;

interface CurrencyInterface
{
	public function toSmallestUnit();
}
