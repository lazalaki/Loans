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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('auth')->group(function() {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@createUser');
    Route::post('activate', 'AuthController@activateUser');
    Route::post('reset', 'AuthController@resetPassword');
    Route::post('new-password', 'AuthController@newPassword');
});

Route::post('/loans', 'LoansController@createLoan');