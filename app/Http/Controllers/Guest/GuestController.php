<?php

namespace App\Http\Controllers\Guest;

use Auth;
use App\Http\Controllers\Controller;
use App\Service\AuthService;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    private $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        try {
            $user = $this->authService->authenticateWithCredentials($request->input('email'), $request->input('password'));

            Auth::login($user);

            return view('user.index');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
