<?php

namespace App\Contracts\Token;

interface TokenRepositoryInterface
{
	/**
	 * Create a new token and associate it to an identifer.
     *
     * @param  string  $identifer
	 * @return void
	 */
	public function createToken($identifer);

	/**
	 * Delete a token by its value.
	 *
     * @param  string  $identifer
	 * @return void
	 */
	public function deleteToken($token_value);

	/**
	 * Delete tokens associated with the identifer.
	 *
     * @param  string  $identifer
	 * @return void
	 */
	public function deleteExisting($identifer);

    /**
     * Delete expired tokens.
     *
     * @return void
     */
    public function deleteExpired();

    /**
     * Determine if the token has expired.
     *
     * @param  array  $token
     * @return bool
     */
    public function isValidToken($token_value);
}
