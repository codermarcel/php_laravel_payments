<?php

namespace App\BusinessLogic\Money;

use App\Contracts\Money\CurrencyInterface;
use Assert\Assertion;

class USD implements CurrencyInterface
{
	private $pennies;

	/**
	 * Private constructor.
	 */
	private function __construct($pennies)
	{
		$this->pennies = $pennies;
	}

	/**
	 * Named constructor.
	 */
	public static function fromPennies($pennies)
	{
		return new static($pennies);
	}

	public static function fromDollars($dollars)
	{
		return new static($dollars * 100);
	}

	/**
	 * Equals
	 */
	public static function equals(USD $input, USD $second)
	{
		return $input->toPennies() === $second->toPennies();
	}

	/**
	 * Bigger or Equals
	 */
	public static function biggerOrEquals(USD $checked, USD $compared_to)
	{
		return $checked->toPennies() >= $compared_to->toPennies();
	}

	/**
	 * Cast to unit.
	 */
	public function toDollars()
	{
		return $this->pennies / 100;
	}

	public function toPennies()
	{
		return $this->pennies;
	}

	public function __toString()
	{
		return strval($this->toPennies());
	}
	
	public function toSmallestUnit()
	{
		return $this->toPennies();
	}
}