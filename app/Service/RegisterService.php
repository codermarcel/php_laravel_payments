<?php

namespace App\Service;

use App\Entity\EncryptionProfile;
use App\Entity\User;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\KeyProtectedByPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ParagonIE\EasyRSA\KeyPair;
use Carbon\Carbon;

class RegisterService 
{
    public function fromRequest(Request $request)
    {
        return $this->fromCredentials($request->input('email'), $request->input('$password'), $request->input('$username'));
    }

	public function fromCredentials($email, $password, $username)
	{
        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->password = $password;

        return $this->fromUser($user);
	}

    public function fromUser(User $user)
    {
        $user->subscription_end = Carbon::now()->addWeeks(1);

        return DB::transaction(function() use($user)
        {
            $user->save();
            $profile = $this->generateEncryptionProfile($user->password);
            $user->encryption_profile()->save($profile);

            return $user;
        });
    }

    public function generateEncryptionProfile($password)
    {
        $keyPair = KeyPair::generateKeyPair(2048);
        $secretKey = $keyPair->getPrivateKey()->getKey();
        $publicKey = $keyPair->getPublicKey()->getKey();

        $master_key = KeyProtectedByPassword::createRandomPasswordProtectedKey($password);
        $encrypted_private_key = Crypto::encrypt($secretKey, $master_key->unlockKey($password));

        $profile = new EncryptionProfile();
        $profile->public_key = $publicKey;
        $profile->master_key = $master_key->saveToAsciiSafeString();
        $profile->encrypted_private_key = $encrypted_private_key;

        return $profile;
    }
}
