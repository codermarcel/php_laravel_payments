<?php

namespace App\Contracts\Token;

interface TokenIdentifierInterface
{
	/**
	 * Get the identifier to be used to create the token.
	 */
	public function getTokenIdentifier();
}
