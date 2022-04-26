<?php

namespace App\Service;

use App\Contracts\Services\Password\PasswordServiceInterface as PasswordService;
use App\Entity\User;
use App\Exceptions\ClientException\LoginException;
use App\Repository\ApiKeyRepository;
use App\Repository\UserRepository;
use Defuse\Crypto\KeyProtectedByPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthService 
{
	private $users;
	private $pws;
	private $api_keys;
	
	public function __construct(UserRepository $users, PasswordService $pws, ApiKeyRepository $api_keys)
	{
		$this->users = $users;
		$this->pws = $pws;
		$this->api_keys = $api_keys;
	}

	public function authenticateWithCredentials($email, $password)
	{
		$user = $this->users->findByEmail($email);

		if ( ! $user)
		{
			throw LoginException::badCredentials($email);
		}

		if ($this->isBanned($user))
		{
			throw LoginException::banned($user);
		}

		if ( ! $this->pws->password_verify($password, $user->password, $user->salt))
		{
			throw LoginException::badCredentials($email);
		}
		
		$user = $this->setUnlockedMasterKeyForUser($user, $password);

		return $user;
	}

    private function setUnlockedMasterKeyForUser(User $user, $password)
    {
        $protected_key = KeyProtectedByPassword::loadFromAsciiSafeString($user->master_key);
        $key = $protected_key->unlockKey($password);
        $user->setUnlockedMasterKey($key);

        return $user;
    }


	public function authenticateWithToken($token)
	{
		return $this->api_keys->getByToken($token);
	}

	public function isBanned(User $user)
	{
		return $user->is_banned;
	}
}
