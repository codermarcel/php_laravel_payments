<?php

namespace App\Service\Token;

use App\Contracts\Token\TokenRepositoryInterface;
use App\Entity\RecoveryCode;
use App\Entity\User;
use App\Repository\RecoveryCodeRepository;
use App\Service\EntityService;
use App\Service\Time\Time;
use Carbon\Carbon;

class DatabaseTokenRepository implements TokenRepositoryInterface
{
	/**
	 * The token expire time in minutes.
	 */
	private $expireTime = null;
	private $codes = null;

	public function __construct($expireTime = null, RecoveryCodeRepository $codes = null)
	{
		$this->expireTime = $expireTime;
		$this->codes = $codes ?: app(RecoveryCodeRepository::class);
	}

	/**
	 * Create a new token and associate it to an identifer.
	 */
	public function createToken($identifer)
	{
		$es = app(EntityService::class);

		$code = new RecoveryCode;
		$code->user_uuid = $identifer;
		
		return $es->createEntity($code);;
	}

	/**
	 * Delete a token by its value.
	 */
	public function deleteToken($token_value)
	{
		return RecoveryCode::where('token', '=', $token_value)->delete();
	}

	/**
	 * Delete tokens associated with the identifer.
	 */
	public function deleteExisting($identifer)
	{
		return RecoveryCode::where('user_uuid', '=', $identifer)->delete();
	}

    /**
     * Delete expired tokens.
     *
     * @return void
     */
    public function deleteExpired()
    {
        $expiredAt = Carbon::now()->subSeconds($this->getCodeExpireTime())->timestamp;

        RecoveryCode::where('created_at', '<', $expiredAt)->delete();
    }

	/**
	 * Determine if the code has expired.
	 *
	 * @param  array  $token
	 * @return bool
	 */
	public function isValidCode(RecoveryCode $code)
	{
		return $code ? $this->tokenIsNotExpired($code) : false;
	}

	/**
	 * Determine if the token has expired.
	 *
	 * @param  array  $token
	 * @return bool
	 */
	public function isValidToken($token_value)
	{
		$code = $this->getByToken($token_value);

		return $code ? $this->tokenIsNotExpired($code) : false;
	}

	/**
	 * Find latest token based on identifier.
	 *
	 * @param  array  $token
	 * @return bool
	 */
	public function findLatest($identifier)
	{
		return $this->codes->findLatestByUserUuid($identifier);
	}

	/**
	 * Find latest token based on identifier.
	 *
	 * @param  array  $token
	 * @return bool
	 */
	public function getByToken($token)
	{
		return $this->codes->getByToken($token);
	}

    /**
     * Determine if the token has expired.
     *
     * @param  array  $token
     * @return bool
     */
    public function tokenIsNotExpired(RecoveryCode $code)
    {
       return ! $this->tokenExpired($code);
    }

    /**
     * Determine if the token has expired.
     *
     * @param  array  $token
     * @return bool
     */
    public function tokenExpired(RecoveryCode $code)
    {
        $expirationTime = strtotime($code['created_at']) + $this->getCodeExpireTime();

        return $expirationTime < $this->getCurrentTime();
    }

    /**
     * Get the current UNIX timestamp.
     *
     * @return int
     */
    protected function getCurrentTime()
    {
        return Time::now();
    }

	/**
	 * Get the token expiration time in minutes.
	 *
	 * Defaults to 60 minutes.
	 */
	private function getCodeExpireTime()
	{
		if (is_null($this->expireTime))
		{
			$this->expireTime = env('RECOVERY_CODE_EXPIRE_MINUTES', 60);
		}
		
		return $this->expireTime;
	}

	/**
	 * Get the token expiration time in minutes.
	 *
	 * Defaults to 60 minutes.
	 */
	private function setExpireTime($minutes = 60)
	{
		$this->expireTime = $minutes;
	}
}
