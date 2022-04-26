<?php

namespace App\Http\Controllers;

use App\Entity\CoinbaseProfile;
use App\Entity\RecoveryCode;
use App\Repository\CoinbaseProfileRepository;
use App\Repository\PaypalProfileRepository;
use App\Service\Api\Api;
use App\Service\EntityService;
use App\Service\Password\PasswordManager;
use Illuminate\Http\Request;

class UserController extends AbstractController
{
	private $service;

	public function __construct(EntityService $service)
	{
		$this->service = $service;
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->show($request);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
    	return $request->user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
    	$user = $request->user();

    	$this->service->updateEntity($user);

    	return Api::ok();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
    	$user = $request->user();
        
    	$this->service->deleteEntity($user);

    	return Api::ok();
    }
}