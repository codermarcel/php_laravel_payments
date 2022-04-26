<?php

namespace App\Service;

class RandomService
{
	/**
	 * Lengths.
	 */
	const LENGTH_TOKEN = 30;
	const LENGTH_SALT = 31;
	const LENGTH_NOUNCE = 32;
	const LENGTH_CODE = 33;

	/**
	 * Generate code
	 */
	public function generateCode()
	{
		return $this->generate(self::LENGTH_CODE);
	}

	/**
	 * Generate token
	 */
	public function generateToken()
	{
		return $this->generate(self::LENGTH_TOKEN);
	}

	/**
	 * Generate salt
	 */
	public function generateSalt()
	{
		return $this->generate(self::LENGTH_SALT);
	}

	/**
	 * Generate nounce
	 */
	public function generateNounce()
	{
		return $this->generate(self::LENGTH_NOUNCE);
	}

	/**
	 * random_bytes is only secure on php >= 7.0, for versions below use this package.
	 * 
	 * {@link https://github.com/paragonie/random_compat}
	 */
	private function generate($length)
	{
		$length = $length / 2; ////bin2hex will double the size.

		return bin2hex(random_bytes($length));
	}
}
