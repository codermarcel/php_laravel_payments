<?php

namespace App\Http\Controllers;

use App\Entity\CoinbaseProfile;
use App\Entity\EncryptionProfile;
use App\Entity\PaypalProfile;
use App\Repository\CoinbaseProfileRepository;
use App\Repository\PaypalProfileRepository;
use App\Service\Api\Api;
use App\Service\EntityService;
use Illuminate\Http\Request;

class ProfileController extends AbstractController
{
	private $service;

	public function __construct(EntityService $service)
	{
		$this->service = $service;
	}

    /**
     * Update Profile
     */
    public function updateCoinbaseProfile(Request $request, CoinbaseProfileRepository $profiles)
    {
    	$user = $request->user();

    	$profile = $profiles->findByUserPrimaryKey($user->getIdentifier()) ?: new CoinbaseProfile;
        $profile->fill($request->all());
        $user->coinbase_profile()->save($profile);

    	return Api::ok();
    }

    /**
     * Show profile
     */
    public function showCoinbaseProfile(Request $request, CoinbaseProfileRepository $profiles)
    {
        $user = $request->user();

        $profile = $profiles->findByUserPrimaryKey($user->getIdentifier());

        return (new Api)
            ->set('profile', $profile)
            ->build();
    }

    //------------------------------------

    /**
     * Update Profile
     */
    public function updatePaypalProfile(Request $request, PaypalProfileRepository $profiles)
    {
        $user = $request->user();

        $profile = $profiles->findByUserPrimaryKey($user->getIdentifier()) ?: new PaypalProfile;
        $profile->fill($request->all());
        $user->paypal_profile()->save($profile);

        return Api::ok();
    }

    /**
     * Show profile
     */
    public function showPaypalProfile(Request $request, PaypalProfileRepository $profiles)
    {
        $user = $request->user();

        $profile = $profiles->findByUserPrimaryKey($user->getIdentifier());

        return (new Api)
            ->set('profile', $profile)
            ->build();
    }

    //------------------------------------

    /**
     * Update Profile
     */
    public function updateEncryptionProfile(Request $request, EncryptionProfileRepository $profiles)
    {
        $user = $request->user();

        $profile = $profiles->findByUserPrimaryKey($user->getIdentifier()) ?: new EncryptionProfile;
        $profile->fill($request->all());
        $user->encryption_profile()->save($profile);

        return Api::ok();
    }

    /**
     * Show profile
     */
    public function showEncryptionProfile(Request $request, EncryptionProfileRepository $profiles)
    {
        $user = $request->user();

        $profile = $profiles->findByUserPrimaryKey($user->getIdentifier());

        return (new Api)
            ->set('profile', $profile)
            ->build();
    }


    public function updateStripeProfile(Request $request, CoinbaseProfileRepository $profiles)
    {
    }


    public function updateBlockchainProfile(Request $request, CoinbaseProfileRepository $profiles)
    {
    }
}