<?php

namespace App\Service\Jwt;

use App\Contracts\Jwt\JwtValidatorInterface;
use App\Entity\DummyUser;
use App\Exceptions\ClientException\JwtException;
use App\Repository\UserRepository;
use App\Service\Jwt\Jwt;
use App\Service\Time\Time;
use Illuminate\Http\Request;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\ValidationData;

class JwtParser extends Jwt
{
	private $token;
	private $validator;

	/**
	 * Stay valid after construct.
	 */
	public function __construct(Token $token, JwtValidatorInterface $validator = null)
	{
		$this->token = $token;

		$validator = $validator ?: app(JwtValidator::class);

		$validator->validateToken($token);
	}

	/**
	 * Parse a jwt from a string.
	 *
	 * @return Lcobucci\JWT\Token
	 * @throws JwtException
	 */
	public static function parseTokenFromString($input)
	{
		if (empty($input))
		{
			throw JwtException::noToken();
		}

		try {
			$token = (new Parser())->parse($input);
		} catch (\Exception $e) {
			throw JwtException::badFormat();
		}

		return $token;
	}

	/**
	 * Named constructor.
	 */
	public static function fromString($input, JwtValidatorInterface $validator = null)
	{
		$token = static::parseTokenFromString($input);

		return new static($token, $validator);
	}

	/**
	 * Named constructor.
	 */
	public static function fromRequest(Request $request)
	{
		$token = $request->bearerToken() ?: $request->header('Authorization'); //support authorize header with and without 'Bearer <token>'
		$token = $token ?: $request->input('jwt');   //if they don't send the token as header, they can send it as request parameter (jwt)
		$token = $token ?: $request->input('token'); //if they don't send the token as header, they can send it as request parameter (token)

		return static::fromString($token);
	}

	/**
	 * Cast token to string.
	 */
	public function toString()
	{
		return (string) $this->token;
	}

	/**
	 * Get user from request
	 * 
	 * @param  Request $request [description]
	 * @return DummyUser
	 */
	public function toUser(UserRepository $users = null)
	{
		$users = $users ?: app(UserRepository::class);

		return $users->getByPrimaryKey($this->getSubject());
	}

	/**
	 * Parse claim from token
	 */
	public function getScope()
	{
		$claim = $this->getClaim('scope');

		return $claim ? (array) $claim : null;
	}

	/**
	 * Parse claim from token
	 */
	public function getSubject()
	{
		return $this->getClaim('sub');
	}

	/**
	 * Parse claim from token
	 */
	public function getAudience()
	{
		return $this->getClaim('aud');
	}

	/**
	 * Parse claim from token
	 */
	public function getOwner()
	{
		return $this->getClaim('owner');
	}

	/**
	 * Get $claim value.
	 *
	 * @return mixed|null  the value of the claim or null.
	 */
	public function getClaim($claim)
	{
		try {
			return $this->token->getClaim($claim);
		} catch (\Exception $e) {
			return null;
		}
	}
}
