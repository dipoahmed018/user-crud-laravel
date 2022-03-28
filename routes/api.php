<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
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

Route::group(['middleware' => 'guest'], function () {
    Route::post('signin/admin', [AuthController::class, 'signinAdmin'])->name('sign.admin');
    Route::post('signin', [AuthController::class, 'signin'])->name('signin');
    Route::post('signup', [AuthController::class, 'signup'])->name('signup');
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('user', fn (Request $request) => ['data' => $request->user()])->name('user.info');
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'admin']], function () {
    Route::apiResource('users', UserController::class);
});
