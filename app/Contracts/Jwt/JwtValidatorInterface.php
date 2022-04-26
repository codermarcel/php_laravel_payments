<?php

namespace App\Contracts\Jwt;

use Lcobucci\JWT\Token;

interface JwtValidatorInterface
{
	/**
	 * Validate a Token.
	 *
	 * @throws JwtException
	 * @return void
	 */
	public function validateToken(Token $token);
}