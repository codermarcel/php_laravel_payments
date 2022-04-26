<?php

namespace App\Entity\Decorator;

use Illuminate\Database\Eloquent\Model;

class ProductDecorator extends BaseDecorator
{
	public static function decorate(Model $product)
	{
		$decorated = new static;
		$decorated->set('name', $product->name);
		$decorated->set('description', $product->description);
		$decorated->set('price_usd', $product->price->toDollars());
		$decorated->set('price_usd_pennies', $product->price->toPennies());
		$decorated->set('status', (string) $product->status);

		return $decorated;
	}
}
