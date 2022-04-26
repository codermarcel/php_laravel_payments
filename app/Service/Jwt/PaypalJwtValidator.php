<?php

namespace App\Service\Jwt;

use App\Contracts\Jwt\JwtValidatorInterface;
use App\Exceptions\ClientException\JwtException;
use App\Service\Jwt\Jwt;
use App\Service\Time\Time;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\ValidationData;

class PaypalJwtValidator extends Jwt implements JwtValidatorInterface
{
	/**
	 * Get a verified and valid token from request.
	 */
	public function validateToken(Token $token)
	{	
		$this->verifyToken($token);
	}

	/**
	 * Verifies the token signature and validates the $token data (iat, nbf, exp)
	 * This method makes sure the jwt is not expired and the content is not changed.
	 * 
	 * @param  Token $jwt [description]
	 * @throws JwtException
	 * @return boolean true
	 */
	private function verifyToken(Token $token)
	{
		$data = new ValidationData(Time::now()); //Use the time now.

		if ( ! $token->verify($this->getSigner(), $this->getSecret()))
		{
			throw JwtException::isForged();
		}

		if ( ! $token->validate($data)) // Validates iat, nbf and exp
		{
			throw JwtException::isInvalid();
		}

		return true;
	}
}
