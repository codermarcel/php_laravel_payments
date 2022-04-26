<?php

namespace App\Service\Token;

use App\Contracts\Token\TokenRepositoryInterface;
use App\Entity\User;
use App\Service\Token\DatabaseTokenRepository;

class TokenManager
{
	private $tokens;

	public function __construct(TokenRepositoryInterface $tokens = null)
	{
		$this->tokens = $tokens ?: app(DatabaseTokenRepository::class);

		$this->cleanup();
	}

	/**
	 * Create a token for a user.
	 */
	public function createToken(User $user)
	{
		$identifer = $this->getUserIdentifer($user);

		$this->deleteExisting($user);

		return $this->tokens->createToken($identifer);
	}

	/**
	 * Delete a token identified by its value.
	 */
	public function deleteToken($token)
	{
		$this->tokens->deleteToken($token);
	}

	/**
	 * Delete tokens associated with a user.
	 */
	public function deleteExisting(User $user)
	{
		$identifer = $this->getUserIdentifer($user);

		$this->tokens->deleteExisting($identifer);
	}

	/**
	 * Delete expired tokens.
	 */
	public function deleteExpired()
	{
		$this->tokens->deleteExpired();
	}

    /**
     * Delete expired tokens.
     */
    public function checkToken($token)
    {
    	$code = $this->tokens->getByToken($token);

    	$this->deleteToken($token);

        if ($this->tokens->isValidCode($code))
        {
        	return $code;
        }

        return null;
    }

    /**
     * Find the latest token.
     */
    public function findLatestValidToken(User $user)
    {
    	$identifier = $this->getUserIdentifer($user);

        $token = $this->tokens->findLatest($identifier);

        return $token && $this->tokens->tokenIsNotExpired($token) ? $token : null;
    }

	/**
	 * Get identifier for the user.
	 */
	private function getUserIdentifer(User $user)
	{
		return $user->uuid;
	}

	/**
	 * Clean up the expired tokens.
	 */
	private function cleanup()
	{
		if ($this->hitLottery())
		{
			\Log::info('Deleting expired codes.');
			$this->deleteExpired();
		}
	}

	/**
	 * Check whether or not you won the lottery.
	 * Default ratio is 1 in 100.000
	 *
	 * @param $chance  the chance to hit the lottery
	 */
	private function hitLottery($chance = 1)
	{
		if (random_int(1, 100000) <= $chance)
		{
			return true;
		}

		return false;
	}
}
