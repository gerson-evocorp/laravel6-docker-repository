<?php

use Illuminate\Http\Request;

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
Route::prefix('oauth')->group(function(){
    Route::post('register/user', 'EntityController@registerUser');

    Route::group(['middleware' => ['api', 'multiauth:admin']], function () {
        Route::post('register/admin', 'EntityController@registerAdmin');
    });
});