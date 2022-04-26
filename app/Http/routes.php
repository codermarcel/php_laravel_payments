<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

$app = app('router');

$app->get('/', function() {
    return view('welcome');
})->name('guest.home');

$app->group(['middleware' => ['web', 'guest']], function () use($app){
    $app->get('/login', function() {
        return view('guest.login');
    })->name('guest.login');

    $app->get('/register', function() {
        return view('guest.register');
    })->name('guest.register');

    $app->get('/recover', function() {
        return view('guest.recover');
    })->name('guest.recover');


    $app->post('/login', [
        'uses' 	 => 'Guest\GuestController@login'
    ]);

    $app->post('/register', [
        'middleware' => 'throttle:5,1',
        'uses' 	 => 'Guest\GuestController@register'
    ]);

    $app->post('/recover', [
        'middleware' => 'throttle:5,1',
        'uses' 	 => 'Guest\GuestController@recover'
    ]);
});


/**
 * User
 */
$app->group(['prefix' => 'user', 'middleware' => ['web', 'auth']], function () use($app){

    $app->get('/', function() {
        return view('user.index');
    })->name('user.index');
    
    $app->resource('/product', 'User\ProductController');

    $app->get('/home', function() {
        return view('user.home');
    })->name('user.home');

    $app->get('/plans', function() {
        $plans = config('plans');
        return view('user.plans', compact('plans'));
    })->name('user.plans');

    $app->get('/packages', function() {
        return view('user.packages');
    })->name('user.packages');

    $app->get('/create', function() {
        return view('user.developer.stub.create');
    })->name('developer.create-stub');

    $app->get('/index', function() {
        return view('user.developer.stub.index');
    })->name('developer.index-stub');



    $app->get('/logout', 'User\UserController@doLogout')->name('user.logout');
//    $app->get('/faq', 'User\UserController@showFaq')->name('user.faq');
//
//    $app->get('/plans', 'User\UserController@showPlans')->name('user.plans');
//    $app->post('/buy-plan/{id}', 'User\UserController@buyPlan')->name('user.buy-plan');
//
//    $app->get('/packages', 'User\UserController@showPackages')->name('user.packages');
//    $app->post('/buy-package/{id}', 'User\UserController@buyPackage')->name('user.buy-package');

    $app->get('/test/{name}', function ($name) {
        return view($name);
    });
});

