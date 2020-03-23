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
    Route::group(['middleware' => ['api', 'multiauth:admin']], function () {
        Route::get('/admin', function (Request $request) {
            // Get the logged admin instance
            return $request->user(); // You can use too `$request->user('admin')` passing the guard.
        });
    });

    Route::group(['middleware' => ['api', 'multiauth:api']], function () {
        Route::get('/user', function (Request $request) {
            // Get the logged user instance
            return $request->user(); // You can use too `$request->user('user')` passing the guard.
        });
    });
});