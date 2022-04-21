<?php

use App\Http\Controllers\Api\V1\NewPasswordController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\EmailVerificationController;

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
require 'api/v1.php';

//Route::get('api/v1/verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');
//
// Route::get('v1/verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');
Route::get('v1/verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');

