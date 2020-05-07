<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', 'AuthenticationController@login');
        Route::post('register', 'AuthenticationController@register');

        Route::group(['middleware' => 'auth.jwt'], function () {
            Route::get('logout', 'AuthenticationController@logout');
        });
    });

    Route::group(['middleware' => 'auth.jwt'], function () {
        Route::resource('users', UsersController::class);
    });
});
