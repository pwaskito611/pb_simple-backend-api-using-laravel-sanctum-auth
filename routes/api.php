<?php

namespace App\Http\Controllers;

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

Route::prefix('auth')->group(function () {
    Route::post('/login', [Auth\LoginController::class ,'index']);
    Route::post('/signup', [Auth\SignupController::class ,'index']);
    Route::post('/forgot-password', [Auth\ForgotPasswordController::class ,'index']);
    Route::post('/reset-password', [Auth\ResetPasswordController::class ,'index']);
    Route::post('/logout', [Auth\LogoutController::class ,'index'])
    ->middleware('auth:sanctum');
}); 

Route::prefix('crud')->group(function () {
    Route::get('/read', [Crud\ReadController::class, 'index']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/create', [Crud\CreateController::class, 'index']);
        Route::put('/update', [Crud\UpdateController::class, 'index']);
        Route::delete('/delete', [Crud\DeleteController::class, 'index']);
    });
});
