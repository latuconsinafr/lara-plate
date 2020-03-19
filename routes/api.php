<?php

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
Route::middleware('auth:api')->group(function () {
    Route::resource('posts', PostsController::class);
});

Route::group([
    'prefix' => 'auth',
], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('signup', 'Auth\RegisterController@signup');

    Route::group([
        'middleware' => 'auth:api',
    ], function () {
        Route::get('logout', 'Auth\LoginController@logout');
        // Route::get('user', 'Auth\AuthController@user');
    });
});

Route::resource('users', UsersController::class);
