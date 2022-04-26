<?php

namespace App\BusinessLogic\Money;

use App\Contracts\Money\CurrencyInterface;
use Assert\Assertion;

class BTC implements CurrencyInterface
{
	/**
	 * 100.000.000 satoshi = 1 btc.
	 */
	const SATOSHI_DIVIDER = 100000000;

	/**
	 * Satoshi is the pluaral form of satoshi.
	 *
	 * @link https://en.bitcoin.it/wiki/Satoshi_(unit)
	 */
	private $satoshi;

	/**
	 * Private constructor.
	 *
	 * Limits were made with a rate of 1 BTC ~ $450 in mind.
	 *
	 * Minimum are 10.000 satoshi (around $0.04)
	 * Maximum are 10 BTC (around $4500)
	 */
	private function __construct($satoshi)
	{
		//Assertion::range($satoshi, 10000, self::SATOSHI_DIVIDER * 10);

		$this->satoshi = $satoshi;
	}

	/**
	 * Named constructor.
	 */
	public static function fromSatoshi($satoshi)
	{
		return new static((string) $satoshi);
	}

	/**
	 * Named constructors.
	 */
	public static function fromBtc($btc)
	{
		return new static($btc * self::SATOSHI_DIVIDER);
	}

	public function toBTC()
	{
		return $this->satoshi / self::SATOSHI_DIVIDER;
	}

	/**
	 * Cast to unit.
	 */
	public function toSatoshi()
	{
		return $this->satoshi;
	}

	public function toSmallestUnit()
	{
		return $this->satoshi;
	}

	public function __toString()
	{
		return strval($this->satoshi());
	}
}